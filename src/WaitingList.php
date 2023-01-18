<?php

class WaitingList
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getPlayers()
    {
        $stmt = $this->db->prepare('SELECT * FROM players ORDER BY group_number ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addPlayer($name)
    {
        // check if player already exists in the list
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM players WHERE name = :name');
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            return array('Player '.$name.' already exists in the list', 'error');
        }

        // get the number of players in the last group
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM players ORDER BY group_number DESC LIMIT 1');
        $stmt->execute();
        $count = $stmt->fetchColumn();

        // add the player to the list
        $group_number = $count > 0 ? ceil($count / 4) : 1;
        $stmt = $this->db->prepare('INSERT INTO players (name, created_at, group_number) VALUES(:name, :time_added, :group_number)');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':time_added', date('Y-m-d H:i:s'));
        $stmt->bindValue(':group_number', $group_number);
        $stmt->execute();

        // log the action
        $stmt = $this->db->prepare('INSERT INTO log (player_name, action, time) VALUES(:name, :action, :time)');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':action', 'add');
        $stmt->bindValue(':time', date('Y-m-d H:i:s'));
        $stmt->execute();

        return array('Player '.$name.' added successfully', 'success');
    }

    public function removePlayer($id)
    {
        // check if player exists in the list
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM players WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            return array('Player does not exist in the list', 'error');
        }

        // get player name for logging
        $stmt = $this->db->prepare('SELECT name FROM players WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $name = $stmt->fetchColumn();
        
        // remove the player from the list
        $stmt = $this->db->prepare('DELETE FROM players WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        
        // log the action
        $stmt = $this->db->prepare('INSERT INTO log (player_name, action, time) VALUES(:name, :action, :time)');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':action', 'remove');
        $stmt->bindValue(':time', date('Y-m-d H:i:s'));
        $stmt->execute();

        return array('Player '.$name.' removed successfully', 'success');
    }
}