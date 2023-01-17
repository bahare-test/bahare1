<?php
	//test comment
	// salam
	// pull request comment
	//pull requseet comment2
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    interface StructureInterface {
        public function pop(): string; 
        public function push($element): void;
        public function list(): array;
    } 

    class Stack implements StructureInterface
    { 
        public function push($element): void
        {
            $conn = new PDO("mysql:host=localhost;dbname=ali", "bahar", "Bahar@1378");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'INSERT INTO stack1 (stack) VALUES (\''.$element.'\')';
            $conn->exec($sql);
        }

        public function pop(): string
        {
            $conn = new PDO("mysql:host=localhost;dbname=ali", "bahar", "Bahar@1378");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM stack1 ORDER BY id DESC LIMIT 1';
            $response = $conn->query($sql)->fetch();
            if (!empty($response['id'])) {
                $result = $response['stack'];
                $conn = new PDO("mysql:host=localhost;dbname=ali", "bahar", "Bahar@1378");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'DELETE FROM stack1 WHERE id = '. $response['id'] .'';
                $conn->exec($sql);
                return $result;
            }
            return '';
        }
        public function list(): array
        {
            $conn = new PDO("mysql:host=localhost;dbname=ali", "bahar", "Bahar@1378");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM stack1 ORDER BY id DESC';
            $response = $conn->query($sql)->fetchAll();
            $result = [];
            if (!empty($response) && is_array($response)) {
                foreach($response as $res) {
                    $result[] = $res['stack'];
                }
            }
            return $result;
        }
    } 

    class Queue implements StructureInterface
    {
        public function push($element): void
        {
            $conn = new PDO("mysql:host=localhost;dbname=ali", "bahar", "Bahar@1378");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'INSERT INTO queue (queue) VALUES (\''.$element.'\')';
            $conn->exec($sql);
        }

        public function pop(): string
        {
            $conn = new PDO("mysql:host=localhost;dbname=ali", "bahar", "Bahar@1378");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM queue ORDER BY Id limit 1';
            $response = $conn->query($sql)->fetch();
            if (!empty($response['id'])) {
                $result = $response['queue'];
                $conn = new PDO("mysql:host=localhost;dbname=ali", "bahar", "Bahar@1378");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'DELETE FROM queue WHERE id = '. $response['id'] .'';
                $conn->exec($sql);
                return $result;
            }
            return '';
        }
        public function list(): array
        {
            $conn = new PDO("mysql:host=localhost;dbname=ali", "bahar", "Bahar@1378");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM queue ORDER BY id asc';
            $response = $conn->query($sql)->fetchAll();
            $result = [];
            if (!empty($response) && is_array($response)) {
                foreach($response as $res) {
                    $result[] = $res['queue'];
                }
            }
            return $result;
        }
    } 

    class StructureService
    {
        public StructureInterface $structure;

        public function __construct(StructureInterface $structure)
        {
            $this->structure = $structure;
        }

        public function pushToStructure(...$data): void 
        {
            foreach ($data as $datum) {
                if (is_string($datum)) {
                    $this->structure->push($datum);
                }
            }
        }
 
        public function popFromStructure(int $number): array
        {
            $response = [];
            for ($i=1; $i<=$number; $i++) {
                $element = $this->structure->pop();
                if ($element !== '') {
                    $response[] = $element;
                }
            }
            return $response;
        }

        public function listOfAllElements(): array
        {
            return $this->structure->list();
        }
    }
    
    $queueService = new StructureService(new queue());
    $queueService->pushToStructure("bahare","ali");
    $s = $queueService->listOfAllElements();
    var_dump($s);

 ?>



