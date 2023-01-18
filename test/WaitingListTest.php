<?php

use PHPUnit\Framework\TestCase;
require_once './src/WaitingList.php';

class WaitingListTest extends TestCase
{
    private $db;
    private $waitingList;

    public function setUp(): void
    {
        $host = '127.0.0.1:3306';
        $user = 'root';
        $pass = '';
        $db = 'players';

        $this->db = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->waitingList = new WaitingList($this->db);
    }

    public function testAddPlayer()
    {
        // Test adding a new player
        $result = $this->waitingList->addPlayer('John');
        $this->assertEquals(array('Player John added successfully', 'success'), $result);

        // Test adding a player that already exists in the list
        $result = $this->waitingList->addPlayer('John');
        $this->assertEquals(array('Player John already exists in the list', 'error'), $result);

        // Test adding a player to a full group
        $this->waitingList->addPlayer('John2');
        $this->waitingList->addPlayer('John3');
        $this->waitingList->addPlayer('John4');
        $result = $this->waitingList->addPlayer('John5');
        // get jojo5's group number
        $stmt = $this->db->prepare('SELECT group_number FROM players WHERE name = :name');
        $stmt->bindValue(':name', 'John5');
        $stmt->execute();
        $group_number = $stmt->fetchColumn();
        $this->assertEquals('2', $group_number);

    }
    public function testRemovePlayer()
    {
        // get name of player with id 1
        $stmt = $this->db->prepare('SELECT name FROM players WHERE id = :id');
        $stmt->bindValue(':id', 1);
        $stmt->execute();
        $name = $stmt->fetchColumn();

        // Test removing a player that exists in the list
        $result = $this->waitingList->removePlayer(1);
        $this->assertEquals(array('Player '.$name.' removed successfully', 'success'), $result);

        // Test removing a player that does not exist in the list
        $result = $this->waitingList->removePlayer(1);
        $this->assertEquals(array('Player does not exist in the list', 'error'), $result);
    }
}
