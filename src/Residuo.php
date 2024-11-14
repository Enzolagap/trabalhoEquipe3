<?php

class Residuo implements ActiveRecord{

    private int $idResiduo;
    
    public function __construct(private string $descricao,private string $coletor, private string $nome){
    }

    public function setIdResiduo(int $idResiduo):void{
        $this->idResiduo = $idResiduo;
    }

    public function getIdResiduo():int{
        return $this->idResiduo;
    }

    public function setDescricao(string $descricao):void{
        $this->descricao = $descricao;
    }

    public function getDescricao():string{
        return $this->descricao;
    }
    public function setColetor(string $coletor):void{
        $this->coletor = $coletor;
    }

    public function getColetor():string{
        return $this->coletor;
    }
    public function setNome(string $nome):void{
        $this->nome = $nome;
    }

    public function getNome():string{
        return $this->nome;
    }
  

    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idResiduo)){
            $sql = "UPDATE residuo SET descricao = '{$this->descricao}' ,coletor = '{$this->coletor}',nome = '{$this->nome}' WHERE idResiduo = {$this->idResiduo}";
        }else{
            $sql = "INSERT INTO residuo (descricao,coletor,nome) VALUES ('{$this->descricao}','{$this->coletor}','{$this->nome}')";
        }
        return $conexao->executa($sql);
        
    }
    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM residuo WHERE idResiduo = {$this->idResiduo}";
        return $conexao->executa($sql);
    }

    public static function find($idResiduo):Residuo{
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo WHERE idResiduo = {$idResiduo}";
        $resultado = $conexao->consulta($sql);
        $r = new Residuo($resultado[0]['descricao'],$resultado[0]['coletor'],$resultado[0]['nome']);
        $r->setIdResiduo($resultado[0]['idResiduo']);
        return $r;
    }
    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo";
        $resultados = $conexao->consulta($sql);
        $residuos = array();
        foreach($resultados as $resultado){
            $r = new Residuo($resultado['descricao'],$resultado['coletor'],$resultado['nome']);
            $r->setIdResiduo($resultado['idResiduo']);
            $residuos[] = $r;
        }
        return $residuos;
    }}