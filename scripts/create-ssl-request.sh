#!/bin/bash

# Create SSL certificate request with extended confgi (using alternate names for SAN)
# Uses 3 alias names 
# Email resulting certificate request to pki-certs@ucsd.edu
# see http://syswiki.ucsd.edu/index.php/SSL_certs for all required info

############ edit server settings 
# Certificate options
CERTDIR=/tmp/certs
CERTFILE=nbcr-ucsd-edu
SSLFILE=myssl.cfg

# Server options
C=US
ST=CA
L="La Jolla"
O="University of California, San Diego"
OU=UCSD
# CN name and additional alias names
CN=nbcr.ucsd.edu
CN2=rocce-vm0.ucsd.edu
CN3=
CN4=

############ end server settings 

# ssl config file text with extension
cnfHead="
[ req ]
default_bits            = 2048
default_md              = md5
string_mask             = nombstr
distinguished_name      = req_distinguished_name
req_extensions          = v3_req

[ v3_req ]
basicConstraints = CA:FALSE
keyUsage = nonRepudiation, digitalSignature, keyEncipherment
subjectAltName = @alt_names

[alt_names]
"
cnfTail="
[ v3_ca ]
basicConstraints        = CA:TRUE
subjectKeyIdentifier    = hash
authorityKeyIdentifier  = keyid:always,issuer:always

[ req_distinguished_name ]
0.organizationName      = Organization Name (company)
organizationalUnitName  = Organizational Unit Name (department, division)
emailAddress            = Email Address
emailAddress_max        = 64
localityName            = Locality Name (city, district)
stateOrProvinceName     = State or Province Name (full name)
countryName             = Country Name (2 letter code)
countryName_min         = 2
countryName_max         = 2
commonName              = Common Name (hostname, IP, or your name)
"

create_dns_string () {
    dnsString="DNS.1 = $CN\n"
    if [ "$CN2" != "" ] ; then
        dnsString+="DNS.2 = $CN2\n"
    fi
    if [ "$CN3" != "" ] ; then
        dnsString+="DNS.2 = $CN3\n"
    fi
    if [ "$CN4" != "" ] ; then
        dnsString+="DNS.2 = $CN4\n"
    fi
}

# create ssl config file with extensions, needed  to use for ssl certificate request
create_config () {
    cd $CERTDIR
    printf  "$cnfHead" > $SSLFILE
    printf  "$dnsString" >> $SSLFILE
    printf  "$cnfTail" >> $SSLFILE
}

# create ssl certificate request
create_request () {
    cd $CERTDIR
    /usr/bin/openssl req -newkey rsa:2048  -nodes -keyout $CERTFILE.key -out $CERTFILE.csr \
            -extensions v3_req -config $SSLFILE \
            -subj "/C=$C/ST=$ST/L=$L/O=$O/OU=$OU/CN=$CN"
    RETVAL=$?

    echo 
    if [ $RETVAL -eq 0 ] ; then
        echo "Created SSL certificate request for $CN"
        echo "CSR file is $CERTFILE.csr, private key file is $CERTFILE.key"
    else 
        echo "Failed to generate SSL certificate request"
    fi
    
    chmod 0400 $CERTFILE.key
}

create_dns_string
create_config
create_request
