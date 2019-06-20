<?php
namespace App\Exceptions\AppSettings;

use App\Exceptions\BaseException;
use Throwable;

/**
 * Class AppSettingsNotFound
 *
 * @package App\Exceptions\AppSettings
 */
class AppSettingsNotFound extends BaseException
{

    /**
     * Custom message
     *
     * @var string Message
     */
    protected $message = "AppSettings '%s' not found.";

    /**
     * AppSettingsNotFound constructor.
     *
     * @param string         $message  ErrorMessage
     * @param integer        $code     ErrorCode
     * @param Throwable|null $previous StackTrace
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->message, $message), $code, $previous);
    }
}
