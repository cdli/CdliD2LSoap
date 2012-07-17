<?php
return array(

    // Debug mode flag
    'debug' => false,

    // Server-specific configuration
    'server' => array(

        // Credentials of user to run webservice calls via
        'username' => '',
        'password' => '', 

        // OU of your organization
        'orgUnit' => 6606,

        // Fully-qualified server hostname
        'hostname' => '',

        // Install code for your D2L instance
        'installCode' => '',

        // SOAP API developer key
        'developerkey' => '',

        // Local Private Key for SSO
        // DOME:  d2l.Tools.Login.LocalPrivateKey
        'ssoToken' => '',

        // SSO Token Time-To-Live
        'ssoTTL' => 30,

    ),

    // Web Service Configuration
    'webservice' => array(

        'client' => array(
            'class' => 'D2LWS_Soap_Client_Adapter_ZendSoap',
        ),

        'common' => array(
            'namespace' => 'http://www.desire2learn.com/services/common/xsd/common-v1_0',
        ),

        'auth' => array(
            'wsdl'      => '[[+server.hostname]]/d2l/AuthenticationTokenService.asmx?WSDL',
            'endpoint'  => '[[+server.hostname]]/d2l/AuthenticationTokenService.asmx',
        ),

        'guid' => array(
            'wsdl'      => '[[+server.hostname]]/d2l/tools/login/D2L.Guid.asmx?wsdl',
            'endpoint'  => '[[+server.hostname]]/d2l/tools/login/D2L.Guid.asmx',
            'ssoLogin'  => '[[+server.hostname]]/d2l/lp/auth/login/ssologin.d2l',
        ),

        'user' => array(
            'wsdl'      => __DIR__ . '/../wsdl/UserManagementService-v1.wsdl',
            'endpoint'  => '[[+server.hostname]]/D2LWS/UserManagementService-v1.asmx',
            'namespace' => 'http://www.desire2learn.com/services/ums/wsdl/UserManagementService-v1_0',
        ),

        'org' => array(
            'wsdl'      => __DIR__ . '/../wsdl/OrgUnitManagementService-v1.wsdl',
            'endpoint'  => '[[+server.hostname]]/D2LWS/OrgUnitManagementService-v1.asmx',
            'namespace' => 'http://www.desire2learn.com/services/ums/wsdl/OrgUnitManagementService-v1_0',
        ),

        'grade' => array(
            'wsdl'      => __DIR__ . '/../wsdl/GradesManagementService-v1.wsdl',
            'endpoint'  => '[[+server.hostname]]/D2LWS/GradesManagementService-v1.asmx',
            'namespace' => 'http://www.desire2learn.com/services/ums/wsdl/GradesManagementService-v1_0',
        ),
    ),
);
