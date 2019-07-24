<?
declare(strict_types = 1);

namespace Paa\Models\DataMapper;

class DataRecordModel
{

    private $id;
    private $idHall;
    private $cinemaName;
    private $seatHall;

/*
CREATE TABLE "cinemaHall" (
    id bigint DEFAULT nextval('cinemahall_id_seq'::regclass) NOT NULL,
    "idHall" integer DEFAULT 0 NOT NULL,
    "cinemaName" character varying(254) DEFAULT ''::character varying NOT NULL,
    "seatHall" integer DEFAULT 0 NOT NULL
);
*/

    public function __construct(int $id = 0, int $idHall = 0, string $cinemaName = '', int $seatHall = 0)
    {
	$this->setId($id);
	$this->setIdHall($idHall);
	$this->setCinemaName($cinemaName);
	$this->setSeatHall($seatHall);
    }
        
    public function getId(): int
    {
	return $this->id;
    }

    public function setId(int $id): self
    {
	$this->id = $id;
	return $this;
    }
   
    public function getIdHall(): int
    {
	return $this->idHall;
    }

    public function setIdHall(int $idHall): self
    {
	$this->idHall = $idHall;
	return $this;
    }
   

    public function getCinemaName(): string
    {
	return $this->cinemaName;
    }

    public function setCinemaName(string $cinemaName): self
    {
	$this->cinemaName = $cinemaName;
	return $this;
    }

    public function getSeatHall(): int
    {
	return $this->seatHall;
    }

    public function setSeatHall(int $seatHall): self
    {
	$this->seatHall = $seatHall;
	return $this;
    }

    public function getCinema()
    {
	return $this;
    }

}
