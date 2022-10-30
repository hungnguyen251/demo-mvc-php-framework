<?php
namespace App\Controller;

use Controller;
use DOMDocument;
use Response;
use SimpleXMLElement;

class DiplomaController extends Controller
{
    public $data = [];

    public function index() {
        $this->data['sub_content']['new_content'] = 'Test Template Content';
        $this->data['sub_content']['new_title'] = 'Test Template Title';
        $this->data['content'] = 'diplomas/list';

        $this->render('layouts\client_layout', $this->data);

        $response = new Response();
        return $response->json($this->data);
    }

    public function testXml() {
        $data = [
            "Project" =>
                ["ExternalProjectID" => 01,
                    "ProjectName" => "Hung Nguyen",
                    "Location" => ["Address" => "06 Ho Tung Mau",
                                    "City" => "Hanoi",
                                    "Province" => "Hanoi",
                                ],
                    "Website" => "https://g-v.asia/",
                    "ContactInformation" => ["ContactPhone" => "0123456789",
                                            "ContactEmail" => "hungnguyen@email.com",
                                        ]
                ]
            ];
        $response = new Response();

        echo '<pre>';
        return $response->toXml($data);  
        echo '</pre>';
    }
}