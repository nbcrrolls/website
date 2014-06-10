SSL host certificate
====================

1 Create a certificate request (create-ssl-request.sh) for nbcr.ucsd.edu and rocce-vm0.ucsd.edu (SAN names)
2 Send request and  other info per http://syswiki.ucsd.edu/index.php/SSL_certs
3 Received certificates via email on 2014-06-09 from support@cert-manager.com:
  Download intermediate and host certs per email links
  Format(s) most suitable for your server software:
      as X509 Certificate only, Base64 encoded: https://cert-manager.com/customer/InCommon/ssl?action=download&sslId=328853&format=x509CO
      as X509 Intermediates/root only, Base64 encoded: https://cert-manager.com/customer/InCommon/ssl?action=download&sslId=328853&format=x509IO
      as X509 Intermediates/root only Reverse, Base64 encoded: https://cert-manager.com/customer/InCommon/ssl?action=download&sslId=328853&format=x509IOR

  Other available formats:
      as PKCS#7 Base64 encoded: https://cert-manager.com/customer/InCommon/ssl?action=download&sslId=328853&format=base64
      as PKCS#7 Bin encoded: https://cert-manager.com/customer/InCommon/ssl?action=download&sslId=328853&format=bin
      as X509, Base64 encoded: https://cert-manager.com/customer/InCommon/ssl?action=download&sslId=328853&format=x509

   * Your renew id: z18szin1pQO-OMUOsZsp
4 Import new certificates from above links as:
  (1) in /etc/pki/tls/certs/:
          nbcr-ucsd-edu.csr - cert request
          nbcr-ucsd-edu-ca-bundle.crt - intermediate cert containing CA certificates
          nbcr-ucsd-edu.crt - host certificate
      in /etc/pki/tls/private/nbcr-ucsd.edu.key (created during cert request)
  (2) edit  /etc/httpd.conf.d/ssl.conf:
        SSLCertificateFile /etc/pki/tls/certs/nbcr-ucsd-edu.crt
        SSLCertificateKeyFile /etc/pki/tls/private/nbcr-ucsd-edu.key
        SSLCertificateChainFile /etc/pki/tls/certs/nbcr-ucsd-edu-ca-bundle.crt
  (3) restart httpd
  (4) check certificate installation using https://www.sslshopper.com/ssl-checker.html (link from syswiki above)
      or http://www.digicert.com/help/
  (4) verify with Firefox https://nbcr.ucsd.edu/wiki works
