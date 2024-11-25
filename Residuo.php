<?php
include_once 'ActiveRecord.php'; 
include_once 'MySQL.php'; 


// Caminho para a pasta onde os arquivos estão localizados
$caminho = __DIR__ . '/src/*.php';  // A pasta 'src' dentro do diretório atual

// Buscar todos os arquivos PHP na pasta
foreach (glob($caminho) as $arquivo) {
    require_once $arquivo;
}

class Residuo implements ActiveRecord {

    private int $idResiduo;
    private ?string $foto;

    // Construtor atualizado para incluir a foto
    public function __construct(private string $descricao, private string $coletor, private string $nome, ?string $foto = null) {
        $this->foto = $foto;
    }

    // Métodos para setar e pegar o ID
    public function setIdResiduo(int $idResiduo): void {
        $this->idResiduo = $idResiduo;
    }

    public function getIdResiduo(): int {
        return $this->idResiduo;
    }

    // Métodos para setar e pegar a Descrição
    public function setDescricao(string $descricao): void {
        $this->descricao = $descricao;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    // Métodos para setar e pegar o Coletor
    public function setColetor(string $coletor): void {
        $this->coletor = $coletor;
    }

    public function getColetor(): string {
        return $this->coletor;
    }

    // Métodos para setar e pegar o Nome
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getNome(): string {
        return $this->nome;
    }

    // Método para setar e pegar a Foto
    public function setFoto(?string $foto): void {
        $this->foto = $foto;
    }

    public function getFoto(): ?string {
        return $this->foto;
    }

    // Método Save: Salva ou atualiza o Residuo no banco de dados
    public function save(): bool {
        $conexao = new MySQL();
        
        // Escapar o conteúdo binário da imagem
        $fotoBinario = $this->foto ? addslashes($this->foto) : null;
        

        // Verifica se é um update (se o idResiduo já existe)
        if (isset($this->idResiduo)) {
            $sql = "UPDATE residuo SET descricao = '{$this->descricao}', coletor = '{$this->coletor}', nome = '{$this->nome}', foto = '{$fotoBinario}' WHERE idResiduo = {$this->idResiduo}";
        } else {
            // Caso seja um insert (novo registro)
            $sql = "INSERT INTO residuo (descricao, coletor, nome, foto) VALUES ('{$this->descricao}', '{$this->coletor}', CONCAT(UPPER(substr('{$this->nome}', 1,1)), LOWER(substr('{$this->nome}', 2,length('{$this->nome}')))), '{$fotoBinario}')";
        }

        return $conexao->executa($sql);
    }

    // Método Delete: Exclui o Residuo do banco de dados
    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM residuo WHERE idResiduo = {$this->idResiduo}";
        return $conexao->executa($sql);
    }

    // Método Find: Localiza um Residuo pelo seu ID
    public static function find($idResiduo): Residuo {
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo WHERE idResiduo = {$idResiduo}";
        $resultado = $conexao->consulta($sql);

        // Cria o objeto Residuo com os dados do banco
        $r = new Residuo($resultado[0]['descricao'], $resultado[0]['coletor'], $resultado[0]['nome'], $resultado[0]['foto']);
        $r->setIdResiduo($resultado[0]['idResiduo']);
        return $r;
    }

    // Método FindAll: Localiza todos os Residuos
    public static function findall(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo";
        $resultados = $conexao->consulta($sql);

        $residuos = [];
        foreach ($resultados as $resultado) {
            // Cria objetos Residuo para cada resultado
            $r = new Residuo($resultado['descricao'], $resultado['coletor'], $resultado['nome'], $resultado['foto']);
            $r->setIdResiduo($resultado['idResiduo']);
            $residuos[] = $r;
        }
        return $residuos;
    }

    public static function findnome($nome): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo WHERE nome LIKE '%{$nome}%'";
        $resultados = $conexao->consulta($sql);
    
        $residuos = [];
        foreach ($resultados as $resultado) {
            $r = new Residuo($resultado['descricao'], $resultado['coletor'], $resultado['nome'], $resultado['foto']);
            $r->setIdResiduo($resultado['idResiduo']);
            $residuos[] = $r;
        }
        return $residuos;
    }
    
    public static function finddescricao($descricao): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo WHERE descricao LIKE '%{$descricao}%'";
        $resultados = $conexao->consulta($sql);
    
        $residuos = [];
        foreach ($resultados as $resultado) {
            $r = new Residuo($resultado['descricao'], $resultado['coletor'], $resultado['nome'], $resultado['foto']);
            $r->setIdResiduo($resultado['idResiduo']);
            $residuos[] = $r;
        }
        return $residuos;
    }
    
    public static function findcoletor($coletor): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo WHERE coletor LIKE '%{$coletor}%'";
        $resultados = $conexao->consulta($sql);
    
        $residuos = [];
        foreach ($resultados as $resultado) {
            $r = new Residuo($resultado['descricao'], $resultado['coletor'], $resultado['nome'], $resultado['foto']);
            $r->setIdResiduo($resultado['idResiduo']);
            $residuos[] = $r;
        }
        return $residuos;
    }
    public static function ascorder(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo ORDER BY nome ASC"; // Ordena normalmente
        $resultados = $conexao->consulta($sql);
    
        $residuos = [];
        foreach ($resultados as $resultado) {
            // Ajusta o nome para que a primeira letra fique em maiúscula
            $nome = ucfirst($resultado['nome']); // Converte a primeira letra em maiúscula
    
            // Cria objetos Residuo para cada resultado
            $r = new Residuo($resultado['descricao'], $resultado['coletor'], $nome, $resultado['foto']);
            $r->setIdResiduo($resultado['idResiduo']);
            $residuos[] = $r;
        }
        return $residuos;
    }
    
    public static function descorder(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo ORDER BY nome DESC"; // Ordena normalmente
        $resultados = $conexao->consulta($sql);
    
        $residuos = [];
        foreach ($resultados as $resultado) {
            // Ajusta o nome para que a primeira letra fique em maiúscula
            $nome = ucfirst($resultado['nome']); // Converte a primeira letra em maiúscula
    
            // Cria objetos Residuo para cada resultado
            $r = new Residuo($resultado['descricao'], $resultado['coletor'], $nome, $resultado['foto']);
            $r->setIdResiduo($resultado['idResiduo']);
            $residuos[] = $r;
        }
        return $residuos;
    }
    

    
}
?>
