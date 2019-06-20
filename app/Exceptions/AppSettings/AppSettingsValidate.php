<?php
namespace App\Exceptions\AppSettings;

use App\Exceptions\BaseException;
use Throwable;

/**
 * Class AppSettingsValidate
 *
 * @package App\Exceptions\AppSettings
 */
class AppSettingsValidate extends BaseException
{

    /**
     * Custom message
     *
     * @var string
     */
    protected $message = "AppSettings has invalid param: ";

    /**
     * AppSettingsValidate constructor.
     *
     * @param string         $message  ErrorMessage
     * @param integer        $code     ErrorCode
     * @param Throwable|null $previous StackTrace
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($this->message . $message, $code, $previous);
    }
}
