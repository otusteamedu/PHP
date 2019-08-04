<?
namespace Paa\Models;

class StatusModel
{

    private $statusArray = [
	'0' => 'Ожидает проверки',
	'1' => 'Опубликован',
	'2' => 'Отклонен'
    ];
    
    public function getStatus(int $status = 0)
    {
	return $this->statusArray[$status];
    }
}
