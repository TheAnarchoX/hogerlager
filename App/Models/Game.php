<?php
/**
 * Created by PhpStorm.
 * User: Jim
 * Date: 27-Oct-17
 * Time: 11:28
 */

namespace App\Models;


class Game {
    /**
     * @var int
     */
    public $number;

    /**
     * @var int
     */
    public $try;

    /**
     * @var string
     */
    public $result;

    /**
     * @var string
     */
    public $leader;

    /**
     * @var string
     */
    public $message;

    /**
     * Game constructor.
     */
    public function __construct() {
        $this->number = (int) rand(1, 10);
        $this->try = 1;
        return $this;
    }

    public function check($guess) {
        if($this->try < 4) {
            if ($guess == $this->number) {
                $this->result = 'success';
                $this->leader = 'Gefeliciteerd!!';
                $this->message = 'Je hebt het getal geraden!';
            } elseif ($guess > $this->number) {
                $this->try++;
                $this->result = 'warning';
                $this->leader = 'Helaas!';
                $this->message = 'Het getal dat we zoeken is lager';
            } elseif ($guess < $this->number) {
                $this->try++;
                $this->result = 'warning';
                $this->leader = 'Helaas!';
                $this->message = 'Het getal dat we zoeken is hoger';
            }
        } else {
            $this->result = 'danger';
            $this->leader ='Wat jammer!';
            $this->message = 'Je hebt het getal niet geraden';
        }
        $_SESSION['game'] = $this;
    }
}