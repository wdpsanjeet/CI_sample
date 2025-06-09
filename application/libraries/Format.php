<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Format class
 * Help convert between various formats such as XML, JSON, CSV, etc.
 *
 * @author    Phil Sturgeon, Chris Kacerguis, @softwarespot
 * @license   http://www.dbad-license.org/
 */
class Format {

    /**
     * Array output format
     */
    const ARRAY_FORMAT = 'array';

    /**
     * Comma Separated Value (CSV) output format
     */
    const CSV_FORMAT = 'csv';

    /**
     * Json output format
     */
    const JSON_FORMAT = 'json';

    /**
     * HTML output format
     */
    const HTML_FORMAT = 'html';

    /**
     * PHP output format
     */
    const PHP_FORMAT = 'php';

    /**
     * Serialized output format
     */
    const SERIALIZED_FORMAT = 'serialized';

    /**
     * XML output format
     */
    const XML_FORMAT = 'xml';

    /**
     * Default format of this class
     */
    const DEFAULT_FORMAT = self::JSON_FORMAT; // Couldn't be DEFAULT, as this is a keyword
// Informational
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518
    // Success

    /**
     * The request has succeeded
     */
    const HTTP_OK = 200;

    /**
     * The server successfully created a new resource
     */
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * The server successfully processed the request, though no content is returned
     */
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229
    // Redirection

    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;

    /**
     * The resource has not been modified since the last request
     */
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    // Client Error

    /**
     * The request cannot be fulfilled due to multiple errors
     */
    const HTTP_BAD_REQUEST = 400;

    /**
     * The user is unauthorized to access the requested resource
     */
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;

    /**
     * The requested resource is unavailable at this present time
     */
    const HTTP_FORBIDDEN = 403;

    /**
     * The requested resource could not be found
     *
     * Note: This is sometimes used to mask if there was an UNAUTHORIZED (401) or
     * FORBIDDEN (403) error, for security reasons
     */
    const HTTP_NOT_FOUND = 404;

    /**
     * The request method is not supported by the following resource
     */
    const HTTP_METHOD_NOT_ALLOWED = 405;

    /**
     * The request was not acceptable
     */
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;

    /**
     * The request could not be completed due to a conflict with the current state
     * of the resource
     */
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_LOCKED = 423;                                                      // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    // Server Error

    /**
     * The server encountered an unexpected error
     *
     * Note: This is a generic error message when no specific message
     * is suitable
     */
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    /**
     * The server does not recognise the request method
     */
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * CodeIgniter instance
     *
     * @var object
     */
    private $_CI;

    /**
     * Data to parse
     *
     * @var mixed
     */
    protected $_data = [];

    /**
     * Type to convert from
     *
     * @var string
     */
    protected $_from_type = NULL;

    /**
     * DO NOT CALL THIS DIRECTLY, USE factory()
     *
     * @param NULL $data
     * @param NULL $from_type
     * @throws Exception
     */
    public function __construct($data = NULL, $from_type = NULL) {
        // Get the CodeIgniter reference
        $this->_CI = &get_instance();

        // Load the inflector helper
        $this->_CI->load->helper('inflector');

        // If the provided data is already formatted we should probably convert it to an array
        if ($from_type !== NULL) {
            if (method_exists($this, '_from_' . $from_type)) {
                $data = call_user_func([$this, '_from_' . $from_type], $data);
            } else {
                throw new Exception('Format class does not support conversion from "' . $from_type . '".');
            }
        }

        // Set the member variable to the data passed
        $this->_data = $data;
    }

    /**
     * Create an instance of the format class
     * e.g: echo $this->format->factory(['foo' => 'bar'])->to_csv();
     *
     * @param mixed $data Data to convert/parse
     * @param string $from_type Type to convert from e.g. json, csv, html
     *
     * @return object Instance of the format class
     */
    public static function factory($data, $from_type = NULL) {
        // $class = __CLASS__;
        // return new $class();

        return new static($data, $from_type);
    }

    // FORMATTING OUTPUT ---------------------------------------------------------

    /**
     * Format data as an array
     *
     * @param mixed|NULL $data Optional data to pass, so as to override the data passed
     * to the constructor
     * @return array Data parsed as an array; otherwise, an empty array
     */
    public function to_array($data = NULL) {
        // If no data is passed as a parameter, then use the data passed
        // via the constructor
        if ($data === NULL && func_num_args() === 0) {
            $data = $this->_data;
        }

        // Cast as an array if not already
        if (is_array($data) === FALSE) {
            $data = (array) $data;
        }

        $array = [];
        foreach ((array) $data as $key => $value) {
            if (is_object($value) === TRUE || is_array($value) === TRUE) {
                $array[$key] = $this->to_array($value);
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    /**
     * Format data as XML
     *
     * @param mixed|NULL $data Optional data to pass, so as to override the data passed
     * to the constructor
     * @param NULL $structure
     * @param string $basenode
     * @return mixed
     */
    public function to_xml($data = NULL, $structure = NULL, $basenode = 'xml') {
        if ($data === NULL && func_num_args() === 0) {
            $data = $this->_data;
        }

        if ($structure === NULL) {
            $structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$basenode />");
        }

        // Force it to be something useful
        if (is_array($data) === FALSE && is_object($data) === FALSE) {
            $data = (array) $data;
        }

        foreach ($data as $key => $value) {

            //change false/true to 0/1
            if (is_bool($value)) {
                $value = (int) $value;
            }

            // no numeric keys in our xml please!
            if (is_numeric($key)) {
                // make string key...
                $key = (singular($basenode) != $basenode) ? singular($basenode) : 'item';
            }

            // replace anything not alpha numeric
            $key = preg_replace('/[^a-z_\-0-9]/i', '', $key);

            if ($key === '_attributes' && (is_array($value) || is_object($value))) {
                $attributes = $value;
                if (is_object($attributes)) {
                    $attributes = get_object_vars($attributes);
                }

                foreach ($attributes as $attribute_name => $attribute_value) {
                    $structure->addAttribute($attribute_name, $attribute_value);
                }
            }
            // if there is another array found recursively call this function
            elseif (is_array($value) || is_object($value)) {
                $node = $structure->addChild($key);

                // recursive call.
                $this->to_xml($value, $node, $key);
            } else {
                // add single node.
                $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');

                $structure->addChild($key, $value);
            }
        }

        return $structure->asXML();
    }

    /**
     * Format data as HTML
     *
     * @param mixed|NULL $data Optional data to pass, so as to override the data passed
     * to the constructor
     * @return mixed
     */
    public function to_html($data = NULL) {
        // If no data is passed as a parameter, then use the data passed
        // via the constructor
        if ($data === NULL && func_num_args() === 0) {
            $data = $this->_data;
        }

        // Cast as an array if not already
        if (is_array($data) === FALSE) {
            $data = (array) $data;
        }

        // Check if it's a multi-dimensional array
        if (isset($data[0]) && count($data) !== count($data, COUNT_RECURSIVE)) {
            // Multi-dimensional array
            $headings = array_keys($data[0]);
        } else {
            // Single array
            $headings = array_keys($data);
            $data = [$data];
        }

        // Load the table library
        $this->_CI->load->library('table');

        $this->_CI->table->set_heading($headings);

        foreach ($data as $row) {
            // Suppressing the "array to string conversion" notice
            // Keep the "evil" @ here
            $row = @array_map('strval', $row);

            $this->_CI->table->add_row($row);
        }

        return $this->_CI->table->generate();
    }

    /**
     * @link http://www.metashock.de/2014/02/create-csv-file-in-memory-php/
     * @param mixed|NULL $data Optional data to pass, so as to override the data passed
     * to the constructor
     * @param string $delimiter The optional delimiter parameter sets the field
     * delimiter (one character only). NULL will use the default value (,)
     * @param string $enclosure The optional enclosure parameter sets the field
     * enclosure (one character only). NULL will use the default value (")
     * @return string A csv string
     */
    public function to_csv($data = NULL, $delimiter = ',', $enclosure = '"') {
        // Use a threshold of 1 MB (1024 * 1024)
        $handle = fopen('php://temp/maxmemory:1048576', 'w');
        if ($handle === FALSE) {
            return NULL;
        }

        // If no data is passed as a parameter, then use the data passed
        // via the constructor
        if ($data === NULL && func_num_args() === 0) {
            $data = $this->_data;
        }

        // If NULL, then set as the default delimiter
        if ($delimiter === NULL) {
            $delimiter = ',';
        }

        // If NULL, then set as the default enclosure
        if ($enclosure === NULL) {
            $enclosure = '"';
        }

        // Cast as an array if not already
        if (is_array($data) === FALSE) {
            $data = (array) $data;
        }

        // Check if it's a multi-dimensional array
        if (isset($data[0]) && count($data) !== count($data, COUNT_RECURSIVE)) {
            // Multi-dimensional array
            $headings = array_keys($data[0]);
        } else {
            // Single array
            $headings = array_keys($data);
            $data = [$data];
        }

        // Apply the headings
        fputcsv($handle, $headings, $delimiter, $enclosure);

        foreach ($data as $record) {
            // If the record is not an array, then break. This is because the 2nd param of
            // fputcsv() should be an array
            if (is_array($record) === FALSE) {
                break;
            }

            // Suppressing the "array to string conversion" notice.
            // Keep the "evil" @ here.
            $record = @ array_map('strval', $record);

            // Returns the length of the string written or FALSE
            fputcsv($handle, $record, $delimiter, $enclosure);
        }

        // Reset the file pointer
        rewind($handle);

        // Retrieve the csv contents
        $csv = stream_get_contents($handle);

        // Close the handle
        fclose($handle);

        // Convert UTF-8 encoding to UTF-16LE which is supported by MS Excel
        $csv = mb_convert_encoding($csv, 'UTF-16LE', 'UTF-8');

        return $csv;
    }

    /**
     * Encode data as json
     *
     * @param mixed|NULL $data Optional data to pass, so as to override the data passed
     * to the constructor
     * @return string Json representation of a value
     */
    public function to_json($data = NULL) {
        // If no data is passed as a parameter, then use the data passed
        // via the constructor
        if ($data === NULL && func_num_args() === 0) {
            $data = $this->_data;
        }

        // Get the callback parameter (if set)
        $callback = $this->_CI->input->get('callback');

        if (empty($callback) === TRUE) {
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        // We only honour a jsonp callback which are valid javascript identifiers
        elseif (preg_match('/^[a-z_\$][a-z0-9\$_]*(\.[a-z_\$][a-z0-9\$_]*)*$/i', $callback)) {
            // Return the data as encoded json with a callback
            return $callback . '(' . json_encode($data, JSON_UNESCAPED_UNICODE) . ');';
        }

        // An invalid jsonp callback function provided.
        // Though I don't believe this should be hardcoded here
        $data['warning'] = 'INVALID JSONP CALLBACK: ' . $callback;

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Encode data as a serialized array
     *
     * @param mixed|NULL $data Optional data to pass, so as to override the data passed
     * to the constructor
     * @return string Serialized data
     */
    public function to_serialized($data = NULL) {
        // If no data is passed as a parameter, then use the data passed
        // via the constructor
        if ($data === NULL && func_num_args() === 0) {
            $data = $this->_data;
        }

        return serialize($data);
    }

    /**
     * Format data using a PHP structure
     *
     * @param mixed|NULL $data Optional data to pass, so as to override the data passed
     * to the constructor
     * @return mixed String representation of a variable
     */
    public function to_php($data = NULL) {
        // If no data is passed as a parameter, then use the data passed
        // via the constructor
        if ($data === NULL && func_num_args() === 0) {
            $data = $this->_data;
        }

        return var_export($data, TRUE);
    }

    // INTERNAL FUNCTIONS

    /**
     * @param string $data XML string
     * @return array XML element object; otherwise, empty array
     */
    protected function _from_xml($data) {
        return $data ? (array) simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA) : [];
    }

    /**
     * @param string $data CSV string
     * @param string $delimiter The optional delimiter parameter sets the field
     * delimiter (one character only). NULL will use the default value (,)
     * @param string $enclosure The optional enclosure parameter sets the field
     * enclosure (one character only). NULL will use the default value (")
     * @return array A multi-dimensional array with the outer array being the number of rows
     * and the inner arrays the individual fields
     */
    protected function _from_csv($data, $delimiter = ',', $enclosure = '"') {
        // If NULL, then set as the default delimiter
        if ($delimiter === NULL) {
            $delimiter = ',';
        }

        // If NULL, then set as the default enclosure
        if ($enclosure === NULL) {
            $enclosure = '"';
        }

        return str_getcsv($data, $delimiter, $enclosure);
    }

    /**
     * @param string $data Encoded json string
     * @return mixed Decoded json string with leading and trailing whitespace removed
     */
    protected function _from_json($data) {
        return json_decode(trim($data));
    }

    /**
     * @param string $data Data to unserialize
     * @return mixed Unserialized data
     */
    protected function _from_serialize($data) {
        return unserialize(trim($data));
    }

    /**
     * @param string $data Data to trim leading and trailing whitespace
     * @return string Data with leading and trailing whitespace removed
     */
    protected function _from_php($data) {
        return trim($data);
    }

}
