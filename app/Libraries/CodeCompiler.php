<?php 
namespace App\Libraries;

class CodeCompiler {
    private $code;
    private $language = 'Desconocido';
    private $variables = [];
    private $variableCounts = [];
    private $conditionalCounts = [
        'if' => 0,
        'else if' => 0,
        'else' => 0,
        'while' => 0,
        'for' => 0,
        'foreach' => 0,
        'switch' => 0,
        'case' => 0
    ];
    public $grammarRules = [
    'comando' => [
        'agregar nombre con precio numero tipo tipo descripcion texto',
        'eliminar nombre'
    ],
    'nombre' => ['[a-zA-Z0-9]+'],      // palabra alfanumérica
    'precio' => ['numero'],
    'numero' => ['[0-9]+(\\.[0-9]+)?'], // decimal o entero
    'tipo' => ['[a-zA-Z]+'],
    'descripcion' => ['texto'],
    'texto' => ['[a-zA-Z0-9\\s]+']
    ];

    public function __construct($filePath) {
        if (!file_exists($filePath)) {
            throw new Exception("El archivo no existe.");
        }
        $this->code = file_get_contents($filePath);
    }

    public function analyze() {
        try {
            $this->detectLanguage();
            echo "Lenguaje detectado: {$this->language}\n";
            $this->checkSyntax();
            $this->checkBalancedSymbols();
            $this->checkBalancedQuotes();
            $this->countConditionals();
            $this->findVariables();
            echo " El código compila correctamente.\n";
            $this->report();
        } catch (Exception $e) {
            echo " Error de compilación: " . $e->getMessage() . "\n";
        }
    }

    private function detectLanguage() {
        if (preg_match('/<\\?php/', $this->code)) {
            $this->language = 'PHP';
        } elseif (preg_match('/\\bdef\\b|print\\(|import /', $this->code)) {
            $this->language = 'Python';
        } elseif (preg_match('/#include\\s+<|using namespace|cout\\s*<</', $this->code)) {
            $this->language = 'C++';
        } elseif (preg_match('/public static void main|System\\.out\\.println/', $this->code)) {
            $this->language = 'Java';
        } else {
            throw new Exception("No se pudo detectar el lenguaje de programación.");
        }
    }

    private function checkSyntax() {
        if ($this->language === 'Desconocido') {
            throw new Exception("Lenguaje no detectado, no se puede verificar la sintaxis.");
        }
    }

    private function checkBalancedSymbols() {
        $symbols = ['(' => ')', '{' => '}', '[' => ']'];
        foreach ($symbols as $open => $close) {
            $openCount = substr_count($this->code, $open);
            $closeCount = substr_count($this->code, $close);
            if ($openCount !== $closeCount) {
                throw new Exception("Desbalance entre '$open' y '$close'. Abiertos: $openCount, Cerrados: $closeCount");
            }
        }
    }

    private function checkBalancedQuotes() {
        $singleQuotes = substr_count($this->code, "'");
        $doubleQuotes = substr_count($this->code, '"');
        if ($singleQuotes % 2 !== 0) {
            throw new Exception("Número impar de comillas simples (').");
        }
        if ($doubleQuotes % 2 !== 0) {
            throw new Exception("Número impar de comillas dobles (\").");
        }
    }

    private function countConditionals() {
        foreach ($this->conditionalCounts as $cond => $count) {
            $pattern = '/\\b' . str_replace(' ', '\\s+', $cond) . '\\b/';
            preg_match_all($pattern, $this->code, $matches);
            $this->conditionalCounts[$cond] = count($matches[0]);
        }
    }

    private function findVariables() {
        $pattern = '';
        switch ($this->language) {
            case 'PHP':
                $pattern = '/\\$(\\w+)/';
                break;
            case 'Python':
                $pattern = '/(\\w+)\\s*=\\s*/';
                break;
            case 'C++':
            case 'Java':
                $pattern = '/(int|float|double|string|char|bool)\\s+(\\w+)/';
                break;
        }
        if ($pattern) {
            preg_match_all($pattern, $this->code, $matches);
            $varList = $this->language === 'PHP' ? $matches[1] : $matches[2];
            foreach ($varList as $var) {
                if (!isset($this->variableCounts[$var])) {
                    $this->variableCounts[$var] = 0;
                }
                $this->variableCounts[$var]++;
            }
            $this->variables = array_keys($this->variableCounts);
        }
    }

    private function report() {
        echo "\nCondicionales encontrados:\n";
        foreach ($this->conditionalCounts as $cond => $count) {
            echo "- {$cond}: {$count}\n";
        }

        echo "\nVariables encontradas (con conteo):\n";
        foreach ($this->variableCounts as $var => $count) {
            echo "- {$var}: {$count}\n";
        }
    }

    public function addCodeLine($line) {
        $this->code .= "\n" . $line;
    }

    public function getCode() {
        return $this->code;
    }

    public function validateCodeByGrammar() {
        foreach (explode("\n", $this->code) as $line) {
            $line = trim($line);
            if ($line === '') continue;
            $isValid = $this->validateGrammarLine($line) ? ' VALIDA' : ' INVALIDA';
            echo "Línea: $line -> $isValid\n";
        }
    }

    private function validateGrammarLine($line) {
    $line = strtolower(trim($line));
    $line = str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $line);

    // Comando para agregar:
    // Ejemplo válido: agregar minecraft con precio 12.5 tipo sandbox descripcion juego de bloques
    if (preg_match('/^agregar\s+.+\s+con\s+precio\s+\d+(\.\d+)?\s+tipo\s+\w+\s+descripcion\s+.+$/', $line)) {
        return true;
    }

    // Comando para eliminar:
    // Ejemplo válido: eliminar tetris
    if (preg_match('/^eliminar\s+.+$/', $line)) {
        return true;
    }

    return false;
}


    public function addGrammarRule($rule) {
        $parts = explode('->', $rule);
        if (count($parts) != 2) {
            echo "Regla inválida.\n";
            return;
        }
        $nonTerminal = trim($parts[0]);
        $productions = array_map('trim', explode(',', $parts[1]));
        if (!isset($this->grammarRules[$nonTerminal])) {
            $this->grammarRules[$nonTerminal] = [];
        }
        $this->grammarRules[$nonTerminal] = array_merge($this->grammarRules[$nonTerminal], $productions);
    }
}

?>