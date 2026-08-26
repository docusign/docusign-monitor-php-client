<?php
/**
 * User: Naveen Gopala
 * Date: 1/25/16
 * Time: 4:58 PM
 */
 
use PHPUnit\Framework\TestCase;

class UnitTests extends TestCase
{

    /*
	 * Test 0 - login
	 */
    public function testLogin()
    {
        $testConfig = new TestConfig();        

        $config = new DocuSign\Monitor\Configuration();
        $config->setHost($testConfig->getHost());

        $testConfig->setApiClient(new DocuSign\Monitor\Client\ApiClient($config));
        $testConfig->getApiClient()->getOAuth()->setOAuthBasePath(
            DocuSign\Monitor\Client\Auth\OAuth::$DEMO_OAUTH_BASE_PATH
        );

        $scope = ["impersonation", "signature"];

        $token = $testConfig->getApiClient()->requestJWTUserToken($testConfig->getIntegratorKey(),$testConfig->getUserId(), $testConfig->getClientKey(), $scope);

        $this->assertInstanceOf('DocuSign\Monitor\Client\Auth\OAuthToken', $token[0]);
        $this->assertArrayHasKey('access_token', $token[0]);

        $user = $testConfig->getApiClient()->getUserInfo($token[0]['access_token']);

        $this->assertNotEmpty($user);
        $this->assertEquals(200, $user[1]);

        $this->assertInstanceOf('DocuSign\Monitor\Client\Auth\UserInfo', $user[0]);
        $this->assertNotEmpty($user[0]);

        $this->assertArrayHasKey('accounts', $user[0]);
        $loginAccount = $user[0]['accounts'][0];
        $accountId = $loginAccount->getAccountId();
        $organization = $loginAccount->getOrganization();

        $this->assertNotEmpty($accountId);
        $this->assertNotNull($organization);
        $organizationId = $organization->getOrganizationId();
        $this->assertNotEmpty($organizationId);

        $testConfig->setAccountId($accountId);

        return $testConfig;
    }
    
    /**
     * @depends testLogin
     */
    public function testDocuMonitor($testConfig)
    {
        $defaultHeaders = $testConfig->getApiClient()->getConfig()->getDefaultHeaders();
        $authorization = $defaultHeaders['Authorization'];
        $accessToken = substr($authorization, strlen('Bearer '));
        $loginAccount = $testConfig->getApiClient()->getUserInfo($accessToken)[0]['accounts'][0];
        $organizationId = $loginAccount->getOrganization()->getOrganizationId();

        $monitorApi = new DocuSign\Monitor\Api\DocuMonitorApi($testConfig->getApiClient());
        $options = new DocuSign\Monitor\Api\DocuMonitorApi\StreamOptions();
        $options->setCursor(gmdate('Y-m-d\TH:i:s\Z', strtotime('-1 day')));
        $options->setLimit(100);
        $stream = $monitorApi->stream($organizationId, $options);

        $this->assertInstanceOf('DocuSign\Monitor\Model\StreamResponse', $stream);
        $this->assertNotEmpty($stream->getEndCursor());
        $this->assertNotNull($stream->getResultData());
        $this->assertInternalType('array', $stream->getResultData());

        if (count($stream->getResultData()) > 0) {
            $this->assertNotEmpty($stream->getResultData()[0]->getEventId());
        }
    }
}

?>
