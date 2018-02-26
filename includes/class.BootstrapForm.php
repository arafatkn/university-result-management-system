<?php

class BootstrapForm {
    
    public function show($method,$action,$data,$submit=array())
    {
        echo '<form method="'.$method.'"';
        if(!empty($action) || strlen($action)>0) echo ' action="'.$action.'"';
        echo '>';
        foreach($data as $arr)
        {
            $fn = $arr[0];
            unset($arr[0]);
            $this->$fn($arr);
        }
        echo '<button type="submit" class="btn ';
        if(isset($submit["class"])) echo $submit["class"];
        else echo 'btn-primary';
        echo '"';
        if(isset($submit["extra"]))
            echo ' '.$submit["extra"];
        echo '>';
        if(isset($submit["value"])) echo $submit["value"];
        else echo 'Submit';
        echo '</button>';
        echo '</form>';
    }
    public function password($data)
    {
        if(!empty($data[3]))
            $data[0] .= '" id="'.$data[3];
        echo '
        <div class="form-group">
            <label for="pwd">'.$data[1].':</label>
            <input type="password" class="form-control" name="'.$data[0].'" placeholder="Enter password">
        </div>';
    }
    public function text($data)
    {
        if(!empty($data[3]))
            $data[0] .= '" id="'.$data[3];
        if(empty($data[2]))
            $data[2] = request($data[0]);
        //if(!empty($data[2]))
            $data[0] .= '" value="'.$data[2];
        echo '
        <div class="form-group">
            <label for="text">'.$data[1].':</label>
            <input type="text" class="form-control" name="'.$data[0].'">
        </div>';
    }
    public function textarea($data)
    {
        if(!empty($data[3]))
            $data[0] .= '" id="'.$data[3];
        if(empty($data[2]))
            $data[2] = request($data[0]);
        echo '
        <div class="form-group">
            <label for="text">'.$data[1].':</label>
            <textarea class="form-control" name="'.$data[0].'">';
        if(!empty($data[2]))
            echo $data[2];
        echo '</textarea>
        </div>';
    }
    public function select($data)
    {
        $name = 'name="'.$data[0].'"';
        if(!empty($data[6]))
            $name .= ' id="'.$data[6];
        if(empty($data[5]))
            $data[5] = request($data[0]);
        echo '
        <div class="form-group">
            <label for="select">'.$data[1].':</label>
            <select class="form-control" '.$name.'"';
            if($data[2]) echo ' multiple';
        echo '>';
        foreach($data[3] as $key=>$value)
        {
            echo '<option';
            if(isset($data[4][$key]))
            {
                echo ' value="'.$data[4][$key].'"';
                if($data[4][$key]==$data[5]) echo ' selected';
            }
            else if($value==$data[5]) echo ' selected';
            echo '>'.$value.'</option>';
        }
        echo '
            </select>
        </div>';
    }
    public function multiText($data)
    {
        foreach($data as $arr)
        {
            $this->text($arr);
        }
    }
    public function multiPass($data)
    {
        foreach($data as $arr)
        {
            $this->password($arr);
        }
    }
    public function multiTextarea($data)
    {
        foreach($data as $arr)
        {
            $this->textarea($arr);
        }
    }
    public function multiSelect($data)
    {
        foreach($data as $arr)
        {
            $this->select($arr);
        }
    }
    
}
    

?>