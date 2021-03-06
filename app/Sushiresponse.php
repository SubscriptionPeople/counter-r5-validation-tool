<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Sushiresponse extends Model
{

    public $timestamps = false;

    public function responsefile()
    {
        return $this->belongsTo('App\Storedfile');
    }

    public function checkresult()
    {
        return $this->belongsTo('App\Checkresult');
    }

    public function delete()
    {
        // Sushiresponses are never deleted, only the associated files
        
        if ($this->responsefile !== null) {
            $this->responsefile->delete();
        }
        if($this->checkresult !== null) {
            $this->checkresult->delete();
        }
    }
    
    public function detachFile()
    {
        $this->responsefile_id = null;
        return $this->save();
    }
    
    public static function store($responsefile, $checkresult, $sushitransaction, $responsetime = 0.0)
    {
        if (! ($responsefile instanceof Storedfile)) {
            throw new \InvalidArgumentException("responsefile invalid, expecting Storedfile");
        }
        if (! ($checkresult instanceof Checkresult)) {
            throw new \InvalidArgumentException("checkresult invalid, expecting Checkresult");
        }
        if (! ($sushitransaction instanceof Sushitransaction)) {
            throw new \InvalidArgumentException("sushitransaction invalid, expecting Sushitransaction");
        }

        $sushiresponse = new Sushiresponse();
        $sushiresponse->responsefile_id = $responsefile->id;
        $sushiresponse->checkresult_id = $checkresult->id;
        $sushiresponse->sushitransaction_id = $sushitransaction->id;
        $sushiresponse->responsetime = $responsetime;
        if (! $sushiresponse->save()) {
            throw new \Exception("failed to save Sushiresponse");
        }

        return $sushiresponse;
    }
}
