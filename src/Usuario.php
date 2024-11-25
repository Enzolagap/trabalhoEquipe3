<?php
include_once 'ActiveRecord.php'; 
include_once 'MySQL.php'; 


// Caminho para a pasta onde os arquivos estão localizados
$caminho = __DIR__ . '/src/*.php';  // A pasta 'src' dentro do diretório atual

// Buscar todos os arquivos PHP na pasta
foreach (glob($caminho) as $arquivo) {
    require_once $arquivo;
}

class Usuario implements ActiveRecord {

    private int $idUsuario;
    

    
    public function __construct(private string $nome, private string $email , private string $senha) {
    
    }

    // Métodos para setar e pegar o ID
    public function setIdUsuario(int $idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    public function getIdUsuario(): int {
        return $this->idUsuario;
    }

    // Métodos para setar e pegar o email
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getEmail(): string {
        return $this->email;
    }

    // Métodos para setar e pegar a senha
    public function setSenha(string $senha): void {
        $this->senha = $senha;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    // Métodos para setar e pegar o Nome
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getNome(): string {
        return $this->nome;
    }


    // Método Save: Salva ou atualiza o Usuario no banco de dados
    public function save(): bool {
        $conexao = new MySQL();
        

        // Verifica se é um update (se o idUsuario já existe)
        if (isset($this->idUsuario)) {
            $sql = "UPDATE usuario SET nome = '{$this->nome}', email = '{$this->email}', senha = '{$this->senha}' WHERE idUsuario = {$this->idUsuario}";
        } else {
            // Caso seja um insert (novo registro)
            $sql = "INSERT INTO usuario (nome, email, senha) VALUES ('{$this->nome}', '{$this->email}', '{$this->senha}')";
        }

        return $conexao->executa($sql);
    }

    // Método Delete: Exclui o Usuario do banco de dados
    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM usuario WHERE idUsuario = {$this->idUsuario}";
        return $conexao->executa($sql);
    }

    // Método Find: Localiza um Usuario pelo seu ID
    public static function find($idUsuario): Usuario {
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario WHERE idUsuario = {$idUsuario}";
        $resultado = $conexao->consulta($sql);

        // Cria o objeto Usuario com os dados do banco
        $u = new Usuario($resultado[0]['nome'], $resultado[0]['email'], $resultado[0]['senha']);
        $u->setIdUsuario($resultado[0]['idUsuario']);
        return $u;
    }

    // Método FindAll: Localiza todos os Usuarios
    public static function findall(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario";
        $resultados = $conexao->consulta($sql);

        $usuarios = [];
        foreach ($resultados as $resultado) {
            // Cria objetos Usuario para cada resultado
            $u = new Usuario($resultado['nome'], $resultado['email'], $resultado['senha']);
            $u->setIdUsuario($resultado['idUsuario']);
            $usuarios[] = $u;
        }
        return $usuarios;
    }

    public static function findnome($nome): ?Usuario {
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario WHERE nome = '$nome'";
        $resultado = $conexao->consulta($sql);
    
        if (empty($resultado)) {
            // Retorna null se nenhum usuário for encontrado
            return null;
        }
    
        // Cria o objeto Usuario com os dados encontrados
        $u = new Usuario($resultado[0]['nome'], $resultado[0]['email'], $resultado[0]['senha']);
        $u->setIdUsuario($resultado[0]['idUsuario']);
        return $u;
    }
    
    

    
}
?>