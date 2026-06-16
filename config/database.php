<?php

class Database
{

  private $host = "localhost";
  private $db = "inteldle";
  private $user = "aluno";
  private $pass = "aluno";

  public function conectar()
  {

    try {

      return new PDO(
        "mysql:host=$this->host;dbname=$this->db;charset=utf8mb4",
        $this->user,
        $this->pass
      );
    } catch (PDOException $e) {

      die($e->getMessage());
    }
  }
}
