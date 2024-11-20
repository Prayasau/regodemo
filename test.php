<?php
// employees data
$employees =  
  array (
    'FatturaElettronicaHeader' => 
    array (
      'DatiTrasmissione' => 
      array (
        'IdTrasmittente' => 
        array (
          'IdPaese' => 'IT',
          'IdCodice' => '00540880861',
        ),
        'ProgressivoInvio' => '1RA7L',
        'FormatoTrasmissione' => 'FPR12',
        'CodiceDestinatario' => '0000000',
        'ContattiTrasmittente' => 
        array (
          'Telefono' => '+39093520982',
          'Email' => 'assistenza@fatturapertutti.it',
        ),
      ),
      'CedentePrestatore' => 
      array (
        'DatiAnagrafici' => 
        array (
          'IdFiscaleIVA' => 
          array (
            'IdPaese' => 'IT',
            'IdCodice' => '04846700658',
          ),
          'CodiceFiscale' => 'CRRFNN75A25G039H',
          'Anagrafica' => 
          array (
            'Nome' => 'Cerrone',
            'Cognome' => 'Fernando',
          ),
          'RegimeFiscale' => 'RF19',
        ),
        'Sede' => 
        array (
          'Indirizzo' => 'Via S.S. 91 per Eboli',
          'NumeroCivico' => '359/A',
          'CAP' => '84022',
          'Comune' => 'CAMPAGNA',
          'Provincia' => 'SA',
          'Nazione' => 'IT',
        ),
        'Contatti' => 
        array (
          'Telefono' => '3382979615',
          'Email' => 'info@fernandocerrone.com',
        ),
      ),
      'CessionarioCommittente' => 
      array (
        'DatiAnagrafici' => 
        array (
          'CodiceFiscale' => 'CRRFNN75A25G039H',
          'Anagrafica' => 
          array (
            'Nome' => 'Fernando',
            'Cognome' => 'Cerrone',
          ),
        ),
        'Sede' => 
        array (
          'Indirizzo' => 'Via Giuseppe Saragat',
          'NumeroCivico' => '4',
          'CAP' => '84022',
          'Comune' => 'Campagna',
          'Provincia' => 'SA',
          'Nazione' => 'IT',
        ),
      ),
    ),
    'FatturaElettronicaBody' => 
    array (
      'DatiGenerali' => 
      array (
        'DatiGeneraliDocumento' => 
        array (
          'TipoDocumento' => 'TD01',
          'Divisa' => 'EUR',
          'Data' => '2022-04-20',
          'Numero' => '3/FE',
          'ImportoTotaleDocumento' => '1.00',
        ),
      ),
      'DatiBeniServizi' => 
      array (
        'DettaglioLinee' => 
        array (
          'NumeroLinea' => '2',
          'Descrizione' => 'prova',
          'Quantita' => '1.000000',
          'PrezzoUnitario' => '1.000000',
          'PrezzoTotale' => '1.000000',
          'AliquotaIVA' => '0.00',
          'Natura' => 'N2.2',
        ),
        'DatiRiepilogo' => 
        array (
          'AliquotaIVA' => '0.00',
          'Natura' => 'N2.2',
          'ImponibileImporto' => '1.00',
          'Imposta' => '0.00',
          'RiferimentoNormativo' => 'FUORI CAMPO IVA CONTRIBUENTI MINIMI',
        ),
      ),
    ),
    'attributes' => 
    array (
      'versione' => 'FPR12',
      'SistemaEmittente' => 'FXT',
    ),
);

// array to xml function
function array_to_xml($data, &$xml_data)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            if (is_numeric($key)) {
                $key = 'FatturaElettronica';
            }
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
}

// creating object of SimpleXMLElement
$xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
<FatturaElettronica xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:p="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" versione="FPR12" SistemaEmittente="FXT"></FatturaElettronica>');

// function call to convert array to xml
array_to_xml($employees, $xml_data);

//saving generated xml file; 
$result = $xml_data->asXML('xml/IT00540880861_1RA7L.xml');


?>