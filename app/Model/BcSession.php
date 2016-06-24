<?php
App::uses('BcAppModel', 'Model');

/**
 * Application model for Baser.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class BcSession extends BcAppModel {
    public $useTable = 'cake_sessions';
}
