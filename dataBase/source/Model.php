<?php

namespace database\source;

require_once 'Connect.php';

abstract class Model {

    public function salvar(string $table, $columns, $values): ?int {
        $columns = implode(", ", $columns);
        $values = implode(", ", $values);

        $stmt = Connect::getInstance()->prepare(
                "INSERT INTO {$table} ({$columns}) VALUES ({$values})"
        );
              
        $stmt->execute();

        return Connect::getInstance()->lastInsertId(); //VERIFICAR SE ESTA REALMENTE RETORNONANDO O ID
    }

    public function logar(string $codigoUsuario, string $senha, string $table): ?int {
        $sql = "SELECT senha, codigo FROM {$table} WHERE codigo = :codigo";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->bindValue(":codigo", $codigoUsuario);
        $stmt->execute();
        $objDados = $stmt->fetch(\PDO::FETCH_OBJ);
        if (!$objDados) {
            return null;
        }

        //VALIDA SE A SENHA COINCIDE COM A DO BD
        if (password_verify($senha, $objDados->senha)) {
            return $objDados->codigo;
        } else {
            return false;
        }
    }

    public function select(string $table, string $chave, string $valorChave,
            string $orderBy = null, array $tableInner = null, array $OnInner = null, string $limit = null) {
        $sql = "SELECT * FROM {$table} ";
        if ($table && $OnInner) {
            for ($i = 0; $i < sizeof($OnInner); $i++) {
                $sql .= " INNER JOIN {$tableInner[$i]} ON {$OnInner[$i]} ";
            }
        }
        $sql .= " WHERE {$chave} = :{$chave} ";
        $sql .= isset($orderBy) ? "ORDER BY {$orderBy}" : "";
        $sql .= isset($limit) ? " LIMIT {$limit} " : "";

        $stmt = Connect::getInstance()->prepare($sql);
        //$stmt->bindValue(":{$chave}", $valorChave, \PDO::PARAM_INT);
        $stmt->bindValue(":{$chave}", $valorChave);
        $stmt->execute();
        $rows = $stmt->rowCount();

        if ($rows <= 0) {
            return null;
        }
        $objDados = (Object) $stmt->fetchAll();
        if ($objDados) {
            return $objDados;
        }
        return null;
    }

    public function selectCampos(string $table, array $campos, string $chave, string $valorChave,
            string $orderBy = null, array $tableInner = null, array $OnInner = null) {
        $sql = "SELECT ";
        $sql .= implode(',', $campos);
        $sql .= " FROM {$table} ";
        if ($table && $OnInner) {
            for ($i = 0; $i < sizeof($OnInner); $i++) {
                $sql .= " INNER JOIN {$tableInner[$i]} ON {$OnInner[$i]} ";
            }
        }
        $sql .= " WHERE {$chave} = :{$chave} ";
        $sql .= isset($orderBy) ? "ORDER BY {$orderBy}" : "";

        $stmt = Connect::getInstance()->prepare($sql);
        //$stmt->bindValue(":{$chave}", $valorChave, \PDO::PARAM_INT);
        $stmt->bindValue(":{$chave}", $valorChave);
        $stmt->execute();
        $rows = $stmt->rowCount();

        if ($rows <= 0) {
            return null;
        }
        $objDados = (Object) $stmt->fetchAll();
        if ($objDados) {
            return $objDados;
        }
        return null;
    }

    public function selectAll(string $table, int $limit = null, string $orderBy = null) {
        $sql = "SELECT * FROM {$table} ";
        $sql .= $orderBy ? " ORDER BY {$orderBy} " : "";
        $sql .= $limit ? " LIMIT {$limit} " : "";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        return $dados;
    }

    public function update($table, array $campos, array $valores, string $chave, string $valorChave) {
        $sql = "UPDATE {$table} SET ";
        for ($i = 0; $i < sizeof($campos); $i++) {
            $sql .= $i > 0 ? ", " : "";
            $sql .= " {$campos[$i]} = {$valores[$i]} ";
        }
        $sql .= " WHERE {$chave} = {$valorChave}";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->execute();
    }

    public function updateCommit($table, array $campos, array $valores, string $chave, string $valorChave): bool {
        $stmt = Connect::getInstance();
        $stmt->beginTransaction();

        $sql = "UPDATE {$table} SET ";
        for ($i = 0; $i < sizeof($campos); $i++) {
            $sql .= $i > 0 ? ", " : "";
            $sql .= " {$campos[$i]} = {$valores[$i]} ";
        }
        $sql .= " WHERE {$chave} = {$valorChave}";
        $stmt->query($sql);
        if($stmt->commit()) {
            return true;
        }
        return false;
        
    }

}
