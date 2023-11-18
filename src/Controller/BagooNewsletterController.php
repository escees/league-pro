<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\LeagueRepository;
use Brevo\Client\Api\ContactsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\CreateContact;
use Exception;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BagooNewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter", name="app.bagoo.newsletter")
     */
    public function index(): Response
    {
        // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

// Uncomment below line to configure authorization using: partner-key
// $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', 'YOUR_API_KEY');

        $apiInstance = new ContactsApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );
        $createContact = new CreateContact(); // \SendinBlue\Client\Model\CreateContact | Values to create a contact

        $createContact['email'] = 'kamil.scislowski87+114@gmail.com';
        $createContact['attributes'] = array('FNAME'=>'Kamil', 'LNAME'=>'Ścisłowski');
        $createContact['listIds'] = array(4);
        $createContact['emailBlacklisted'] = false;
        $createContact['smsBlacklisted'] = false;
        $createContact['updateEnabled'] = false;

        try {
            $result = $apiInstance->createContact($createContact);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
        }

        return $this->json(['success' => true]);
    }
}
