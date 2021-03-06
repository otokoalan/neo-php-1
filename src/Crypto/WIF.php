<?php

namespace NeoPHP\Crypto;

use NeoPHP\Crypto\Base58;
use NeoPHP\Tools;

//taken from: https://en.bitcoin.it/wiki/Wallet_import_format


class WIF
{

    /**
     * getWifForPrivateKey function.
     *
     * @access public
     * @static
     * @param mixed $privateKey
     * @return void
     */

    public static function getWifForPrivateKey($privateKey)
    {
        return Base58::checkEncode($privateKey);
    }


    /**
     * getPrivateKeyFromWif function.
     *
     * @access public
     * @static
     * @param mixed $wif
     * @return void
     */

    public static function getPrivateKeyFromWif($wif)
    {
        return Base58::checkDecode($wif);
    }    
    
    /**
     * getScriptHashFromAddress function.
     * 
     * @access public
     * @param mixed $address
     * @return void
     */
    public static function getScriptHashFromAddress($address) {
	    return \NeoPHP\Tools\StringTools::reverseHex(Base58::checkDecode($address,1,3));
    } 

    /**
     * validateWif function.
     *
     * @access public
     * @static
     * @param mixed $wif
     * @return void
     */

    public static function validateWif($wif)
    {
        //validate the WIF
        $uncompressedWif = BCMathUtils::bc2bin(Base58::decode($wif));

        //filter out last 4 bytes
        $uncompressedWifNoChecksum = substr($uncompressedWif, 0, -4);

        //check if the last 4 bytes wwith the first four of the uncompressed wif, with SHA256 twice
        return (substr($uncompressedWif, -4) == substr(Hash::SHA256(Hash::SHA256($uncompressedWifNoChecksum)), 0, 4));
    }
    
    

}
