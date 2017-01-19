<?php

namespace AiliDong\Session\Storage\Handler;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\MongoDbSessionHandler;
/**
 * MongoDB session handler.
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class MongoHandler extends MongoDbSessionHandler
{

    public function write($sessionId, $data)
    {
        $expiry = $this->createDateTime(time() + (int) ini_get('session.gc_maxlifetime'));
        $fields = array(
            $this->options['time_field'] => $this->createDateTime(),
            $this->options['expiry_field'] => $expiry,
        );
        $options = array('upsert' => true);
        if ($this->mongo instanceof \MongoDB\Client) {
            $fields[$this->options['data_field']] = new \MongoDB\BSON\Binary($data, \MongoDB\BSON\Binary::TYPE_OLD_BINARY);
        } else {
            $fields[$this->options['data_field']] = new \MongoBinData($data, \MongoBinData::BYTE_ARRAY);
            $options['multiple'] = false;
        }
        $methodName = $this->mongo instanceof \MongoDB\Client ? 'updateOne' : 'update';
        $this->getCollection()->$methodName(
            array($this->options['id_field'] => $sessionId),
            array('$set' => $fields),
            $options
        );
        return true;
    }

}
