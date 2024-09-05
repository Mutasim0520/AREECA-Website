<?php

class Map extends Model {
    private $table = "maps";
    
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createMapTable(); 
            $this->createMapGeoDataTable();
        } catch (Exception $e) {
            echo 'Table Creation Error: ' . $e->getMessage();
        }
    }

    private function createMapTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS maps (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    path VARCHAR(100) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ";
            $this->db->exec($sql);
            echo "Maps table created successfully.<br>";
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }     
    }

    private function createMapGeoDataTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS map_geo_data (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    map_id INT NOT NULL,
                    properties JSON,
                    geo_data GEOMETRY NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (map_id) REFERENCES maps(id) ON DELETE CASCADE
                )
            ";
            $this->db->exec($sql);
            echo "MapGeoData table created successfully.<br>";
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }     
    }
    //fetch data from map model
    public function getMaps($id=NULL) {
        try{
            $sql = "SELECT 
                        maps.id AS id,
                        maps.name AS file_name,
                        maps.path AS file_path,
                    CONCAT('[', GROUP_CONCAT(
                        CONCAT(
                        '{\"properties\": ', map_geo_data.properties,  
                            '}'
                        ) 
                        SEPARATOR ','
                    ), ']') AS properties,
                    CONCAT('[', GROUP_CONCAT(
                        CONCAT(
                            '{\"geometry\": ', ST_AsGeoJSON(map_geo_data.geo_data), 
                            '}'
                        ) 
                        SEPARATOR ','
                    ), ']') AS geometry
                FROM
                    maps
                LEFT JOIN 
                    map_geo_data ON maps.id = map_geo_data.map_id
                GROUP BY 
                    maps.id";

                        
    
            $query = $this->db->prepare($sql);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }catch (PDOException $e) {
            echo 'Read error: ' . $e->getMessage();
            return false;
        }
    }
    
    //insert into map model
    public function insert($name, $path, $geoData) {
        try {
            // Prepare an SQL statement
            $sql = "INSERT INTO maps (name,path) VALUES (:name, :path)";
            $query = $this->db->prepare($sql);
            
            // Bind parameters
            $query->bindParam(':name', $name);
            $query->bindParam(':path', $path);
            
            // Execute the query
            if ($query->execute()) {
                try{
                    $sql = $this->db->prepare("SELECT id FROM maps ORDER BY id DESC LIMIT 1");
                    $sql->execute();
                    $map = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $geoDataInsertion = $this->insertGeoData($map[0]['id'],$geoData);
                    return true;
                }catch (PDOException $e) {
                    return false;
                }
                
            }
            return false;
        } catch (PDOException $e) {
            echo 'Insert error: ' . $e->getMessage();
            return false;
        }
    }

    public function insertGeoData($map_id, $geoData) {
        try {
            $geoData = json_decode($geoData);
            foreach ($geoData as $data) {
                $properties = json_encode($data->properties);
                
                // Convert GeoJSON geometry to WKT
                $geometryType = strtoupper($data->geometry->type);
                $coordinates = $data->geometry->coordinates;
                $wkt = $this->convertGeoJSONToWKT($geometryType, $coordinates);
                
                $sql = "INSERT INTO map_geo_data (map_id, properties, geo_data) VALUES (:map_id, :properties, ST_GeomFromText(:geo_data))";
                $query = $this->db->prepare($sql);
                
                // Bind parameters
                $query->bindParam(':map_id', $map_id);
                $query->bindParam(':properties', $properties);
                $query->bindParam(':geo_data', $wkt);
                $query->execute();
            }
        } catch (PDOException $e) {
            echo 'Insert error: ' . $e->getMessage();
            return false;
        }
    }

    //delete item
    public function deleteMap($id){
        if($id){
            $query = $this->db->prepare("DELETE FROM maps WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    private function convertGeoJSONToWKT($geometryType, $coordinates) {
        switch ($geometryType) {
            case 'POINT':
                return sprintf('POINT(%s %s)', $coordinates[0], $coordinates[1]);
            case 'LINESTRING':
                return sprintf('LINESTRING(%s)', implode(', ', array_map(function($coord) {
                    return sprintf('%s %s', $coord[0], $coord[1]);
                }, $coordinates)));
            case 'POLYGON':
                $rings = array_map(function($ring) {
                    return implode(', ', array_map(function($coord) {
                        return sprintf('%s %s', $coord[0], $coord[1]);
                    }, $ring));
                }, $coordinates);
                return sprintf('POLYGON((%s))', implode('),(', $rings));
            // Add more cases as needed for MULTIPOINT, MULTILINESTRING, MULTIPOLYGON, etc.
            default:
                throw new Exception('Unsupported geometry type: ' . $geometryType);
        }
    }
}
