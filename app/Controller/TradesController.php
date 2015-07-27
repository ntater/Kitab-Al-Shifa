<?php
App::uses('AppController', 'Controller', 'Sanitize', 'Utility');

/**
 * Trades Controller
 *
 * @property Trade $Trade
 *
 */
class TradesController extends AppController {
/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Js', 'Cache', 'PhysicianPicker', 'DatePicker', 'Time', 'TradeStatus', 'Text');
	public $components = array('RequestHandler', 'Search.Prg');
	public $scaffold = 'admin';
	var $paginate = array(
			'recursive' => '2',
	);

/* 	public $presetVars = array(
			array('field' => 'month', 'type' => 'value'),
			array('field' => 'year', 'type' => 'value'),
			array('field' => 'location', 'type' => 'value', 'formField' => 'location', 'modelField' => 'location', 'model' => 'Location')
	);
 */

/**
 * index method
 *
 * @return void
 */
	public function history() {
		//Set paginate conditions from passed arguments
		$this->paginate['conditions'] = $this->Trade->parseCriteria($this->passedArgs);
		$this->paginate['limit'] = 10;

		//Set usersId to either the query or the current user's ID if not available
		$usersId = (isset($this->request->query['id']) ? $this->request->query['id'] : $this->_usersId());

		$this->set('usersId', $usersId);

		$this->paginate = array(
				'paramType' => 'querystring',
				'recursive' => -1,
				'order' => 'Trade.status ASC',
				'limit' => 10,
				'fields' => array(
						'status',
						'user_id',
						'user_status',
						'token',
						'shift_id'),
				'joins' => array(array(
						'table' => 'trades_details',
						'alias' => 'TradesDetail',
						'type' => 'RIGHT',
						'conditions' => array(
								'Trade.id = TradesDetail.trade_id',
						)
				)),
				'contain' => array(
						'User' => array(
								'fields' => array(
										'name',
										'id')),
						'TradesDetail' => array(
								'fields' => array(
										'id',
										'token',
										'user_id',
										'status'),
								'User' => array(
										'fields' => array(
												'id',
												'name'))
						),
						'Shift' => array(
								'fields' => array(
										'date',
										'shifts_type_id'),
								'ShiftsType' => array(
										'fields' => array(
												'location_id',
												'times'),
										'Location' => array(
												'fields' => array(
														'location')
										)
								)
						)
				)
		);
		$this->set('trades', $this->paginate(array(
				'OR' => array(
					'Trade.user_id' => $usersId,
					'TradesDetail.user_id' => $usersId))));
		
		$this->render();
	}

/**
 * add method
 *
 * @return void
 */
	public function index() {
		$recipientNotPresent = false;
		$originatorNotPresent = false;
		$checkDuplicate = false;
		if ($this->request->isPost() && $this->request->data) {
			if (isset($this->request->data['Trade']['shift_id']) && isset($this->request->data['Trade']['user_id'])) {
				$checkDuplicate = $this->checkDuplicate($this->request->data['Trade']['shift_id'], $this->request->data['Trade']['user_id']);
			}
			if (!isset($this->request->data['TradesDetail'])) {
				$recipientNotPresent = true;
			}
			if (isset($this->request->data['TradesDetail']) && !$checkDuplicate && $this->Trade->saveAssociated($this->request->data, array(
				'validate' => 'first'))) {
					$this->Session->setFlash(__('The trade has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The trade could not be saved. Please, try again.'));
			}
		}
		if (isset($this->request->query['id'])) {
			$this->set('usersId', $this->request->query['id']);
		}
		else {
			$this->set('usersId', $this->_usersId());
		}
		$this->set('groupList', $this->User->getGroupsForUser($this->_usersId(), array(), true, true));
		$this->set('recipientNotPresent', $recipientNotPresent);
		$this->set('originatorNotPresent', $originatorNotPresent);
		$this->set('checkDuplicate', $checkDuplicate);
		$this->render();
	}

	function compare() {
		$params = array();
		$this->loadModel('Calendar');
		if ($this->request->is('post')) {
			if (isset($this->request->data['User']) && isset($this->request->data['Calendar'])) {
				$i = 0;
				$masterSet['calendar'] = $this->Calendar->findById($this->request->data['Calendar']['id']);
					foreach ($this->request->data['User'] as $users) {
						$params = $params + array('id[' .$i. ']' => $users['id']);
						$i++;
					}
					$params = $params + array('calendar' => $this->request->data['Calendar']['id']);
					$redirect = array('controller' => 'shifts', 'action' => 'calendarView') + $params;
				return $this->redirect($redirect);
			}
		}
		$this->set('calendars', $this->Calendar->find('list'));
		$this->render();
	}

	/**
	 *
	 * Deal with unprocessed shift trade requests.
	 * Meant for a cron job.
	 *
	 */
	public function startUnprocessed() {
		App::import('Lib', 'TradeRequest');
		$this->_TradeRequest = new TradeRequest();

		$unprocessedTrades = $this->Trade->getUnprocessedTrades();

		//Find unprocessed trade details within the trade
		foreach ($unprocessedTrades as $trade) {
			//Has the trade been approved by the originator?
			if ($trade['Trade']['user_status'] < 1) {
				//TODO: Stubbed as 'email' for now. Eventually will allow user choice through getCommunicatinoMethod
				//Get communication method preference for receiving user
				$method = $this->User->getCommunicationMethod($trade['User']['id']);

				$sendOriginator = $this->_TradeRequest->sendOriginator($trade['Trade']['id'], $trade['User'], $trade['Shift'], $method);
				if ($sendOriginator['return'] == true) {
					// Assuming success, update Status of TradesDetail to 1
					$this->Trade->read(null, $trade['Trade']['id']);
					$this->Trade->set('user_status', 1);
					$this->Trade->set('token', $sendOriginator['token']);
					$this->Trade->save();

					// Write log indicating trade detail was done
					CakeLog::write('TradeRequest', '[Trades][id]: '.$trade['Trade']['id'] . '; An email was sent to '. $trade['User']['name'] . ', who is owner of the trade');
				}
				else {
					CakeLog::write('TradeRequest', '[Trades][id]: '.$trade['Trade']['id'] . '; An email FAILED to '. $trade['User']['name'] . ', who is owner of the trade');
				}
			}
			if ($trade['Trade']['user_status'] == 2) {
				foreach ($trade['TradesDetail'] as $tradesDetail) {
					//TODO: Stubbed as 'email' for now. Eventually will allow user choice through getCommunicatinoMethod
					//Get communication method preference for receiving user
					$method = $this->User->getCommunicationMethod($tradesDetail['User']['id']);
					$sendDetails = $this->_TradeRequest->send($tradesDetail['id'], $trade['User'], $tradesDetail['User'], $trade['Shift'], $method);
					if ($sendDetails['return'] == true) {
						// Assuming success, update Status of TradesDetail to 1
						$this->Trade->TradesDetail->read(null, $tradesDetail['id']);
						$this->Trade->TradesDetail->set('status', 1);
						$this->Trade->TradesDetail->set('token', $sendDetails['token']);
						$this->Trade->TradesDetail->save();

						// Write log indicating trade detail was done
						CakeLog::write('TradeRequest', 'tradesDetail[id]: '.$tradesDetail['id'] . '; An email was sent to '. $tradesDetail['User']['name']);
					}
					else {
						return $this->Session->setFlash(__('The trade could not be saved. Please, try again.'));
					}

				}

				// Assuming success, update Status of Trade to 1
				$this->Trade->read(null, $trade['Trade']['id']);
				$this->Trade->set('status', 1);
				if ($this->Trade->save()) {
					// Write log indicating trade was done
					CakeLog::write('TradeRequest', 'trade[Trade][id]: ' .$trade['Trade']['id'] . '; Changed status to 1');
				} else {
					CakeLog::write('TradeRequest', 'trade[Trade][id]: ' .$trade['Trade']['id'] . '; Failed to process trade');
				}
			}
		}
		$this->set('success', 1);
		$this->render('/Trades/start_unprocessed');
	}

	/**
	 * Complete accepted
	 * Enter accepted shift trade into calendar
	 */
	public function completeAccepted() {
		//TODO: Get shifts where the Originator has accepted and at least one (and hopefully only
		// one) Recipient has accepted

		$trades = $this->Trade->find('all', array(
					'fields' => array(
						'Trade.id',
						'Trade.user_id',
						'Trade.shift_id'),
					'conditions' => array(
						'Trade.status' => 1,
						'Trade.user_status' => 2),
					'contain' => array(
						'Shift' => array(
							'fields' => array(
								'id'
							)
						),
						'TradesDetail' => array(
							'fields' => array(
								'trade_id',
								'user_id',
								'status'
							),
							'conditions' => array(
								'status' => 2
							)
						)
					)
				));

		//TODO: Save updated shift
		foreach($trades as $trade) {
			if (isset($trade['TradesDetail'][0]['status'])) {
				$this->Trade->Shift->read(null, $trade['Trade']['shift_id']);
				$this->Trade->Shift->set('user_id', $trade['TradesDetail'][0]['user_id']);
				$this->Trade->Shift->set('updated', date("Y-m-d H:i:s",time()));
				$this->Trade->Shift->save();

				$this->Trade->read(null, $trade['Trade']['id']);
				$this->Trade->set('status', 2);
				$this->Trade->save();

				//Log successfully completed trade.
				CakeLog::write('TradeComplete', 'trade[Trade][id]: ' .$trade['Trade']['id'] . '; Entered trade on calendar for shift ' . $trade['Trade']['shift_id'] . ' from ' . $trade['Trade']['user_id'] . ' to ' . $trade['TradesDetail'][0]['user_id']);
			}
		}

		$this->set('success', 1);
		$this->render();
	}

	public function accept() {
		$return = $this->changeStatus($this->request, 2);
		if ($return == true) {
			return $this->Session->setFlash(__('You have successfully accepted the trade.'));
		}
		else {
			return $return;
		}
		$this->render();
	}

	public function reject() {
		$return = $this->changeStatus($this->request, 3);
		if ($return == true) {
			return $this->Session->setFlash(__('You have rejected this trade.'));
		}
		else {
			return $return;
		}
		$this->render();
	}


	public function changeStatus($request, $status) {
		if (!isset($this->request) || !isset($this->request->query['id']) || !isset($this->request->query['token'])) {
			throw new NotFoundException(__('Invalid trade or trade parameters missing'));
		}

		App::import('Lib', 'TradeRequest');
		$this->_TradeRequest = new TradeRequest();

		$token = $request->query['token'];
		$id = $request->query['id'];

		$trade = $this->Trade->find('first', array(
					'fields' => array(
						'Trade.id',
						'Trade.token',
						'Trade.user_id',
						'Trade.shift_id'),
					'conditions' => array(
						'Trade.id' => $id,
						'Trade.status' => 0,
						'Trade.user_status' => 1),
					'contain' => array(
						'Shift' => array(
							'fields' => array(
								'id',
								'date'),
							'ShiftsType' => array(
								'fields' => array(
									'times'),
								'Location' => array(
									'location'
								)
							)
						),
						'User' => array(
							'fields' => array(
								'id',
								'name',
								'email'
							)
						)
					)
		));

		if (empty($trade)) {
			throw new NotFoundException(__('Trade not found or already acted upon'));
		}


		if ($token == $trade['Trade']['token']) {
			$this->Trade->read(null, $id);
			$this->Trade->set('user_status', $status);
			if ($this->Trade->save()) {
				//$this->_TradeRequest->sendOriginatorStatusChange($status, $trade);
				CakeLog::write('TradeRequest', 'trade[Trade][id]: ' .$trade['Trade']['id'] . '; Changed user_status to '. $status);
				return true;
			}
			else {
				CakeLog::write('TradeRequest', 'trade[Trade][id]: ' .$trade['Trade']['id'] . '; Error changing user_status');
				return $this->Session->setFlash(__('An error has occured during your request.'));
			}
		}
		else {
			CakeLog::write('TradeRequest', 'trade[Trade][id]: ' .$trade['Trade']['id'] . '; Wrong token');
			return $this->Session->setFlash(__('Sorry, but your token is wrong. You are not authorized to accept or reject this trade.'));
		}
	}

	/*
	 * Check duplicate trade and return true if duplicate found
	 *
	 */
	public function checkDuplicate($shiftId, $userId) {
		$trade = $this->Trade->find('first', array(
					'fields' => array(
						'Trade.user_id',
						'Trade.shift_id',
						'Trade.user_status',
								'Trade.status'),
							'conditions' => array(
								'Trade.user_status <' => 2,
								'Trade.status !=' => 2,
								'Trade.user_id' => $userId,
								'Trade.shift_id' => $shiftId),
		));

		if ($trade) {
			return true;
		}
		else {
			return false;
		}
	}
}