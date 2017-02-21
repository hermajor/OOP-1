<?php
namespace model\classes;

class PermutationErrorHandler
{
	
	static public function getErrorName($error){
        $errors = array(
            E_ERROR             => 'ERROR',
            E_WARNING           => 'WARNING',
            E_PARSE             => 'PARSE',
            E_NOTICE            => 'NOTICE',
            E_CORE_ERROR        => 'CORE_ERROR',
            E_CORE_WARNING      => 'CORE_WARNING',
            E_COMPILE_ERROR     => 'COMPILE_ERROR',
            E_COMPILE_WARNING   => 'COMPILE_WARNING',
            E_USER_ERROR        => 'USER_ERROR',
            E_USER_WARNING      => 'USER_WARNING',
            E_USER_NOTICE       => 'USER_NOTICE',
            E_STRICT            => 'STRICT',
            E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
            E_DEPRECATED        => 'DEPRECATED',
            E_USER_DEPRECATED   => 'USER_DEPRECATED',
        );
        if(array_key_exists($error, $errors)){
            return $errors[$error] . " [$error]";
        }
        return $error;
    }
	
	public function register()
    {
        // говорим php отслеживать все возможные ошибки
        ini_set('display_errors', 'on');
        error_reporting(E_ALL | E_STRICT);
        // регистрируем свой обработчик ошибок
        set_error_handler(array($this, 'errorHandler'));
        // регистрируем свой обработчик выброшенных исключений
        set_exception_handler(array($this, 'exceptionHandler'));
        // регистрируем свою функцию, выполняющуюся перед завершением скрипат
        // нужна для отлова фатальных ошибок. На практике используется редко.
        //register_shutdown_function([$this, 'fatalErrorHandler']);
    }
	
	public function errorHandler($errno, $errstr, $file, $line)
    {
        // здесь можно произвести запись ошибки в лог, если есть необходимость
        // выводим информацию об ошибке в браузере
        $this->showError($errno, $errstr, $file, $line);
        // возвращаем true, чтоб управление обработкой ошибок НЕ было передано встроенному обработчику
        return true;
    }
	
	public function exceptionHandler(\Exception $e)
    {
        // выводим информацию об исключении в браузере
        $this->showError(get_class($e), $e->getMessage(), $e->getFile(), $e->getLine(), 404);
    }
	
	 public function showError($errno, $errstr, $file, $line, $status = 500)
    {
        header("HTTP/1.1 $status");
        echo $message = '<b>' . self::getErrorName($errno) . "</b><hr>" . $errstr . '<hr> file: ' . $file . '<hr> line: ' . $line . '<hr>';
        echo '<br>';
    }

}