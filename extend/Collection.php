<?php

class Collection
{
    private $items = array();

    public function addItem($key,$obj) {
        if ($key == null) {
            $this->items[] = $obj;
        }
        else {
            if (isset($this->items[$key])) {
                throw new KeyHasUseException("Key $key already in use.");
            }
            else {
                $this->items[$key] = $obj;
            }
        }
    }

    public function deleteItem($key) {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
    }
        else {
            throw new KeyInvalidException("Invalid key $key.");
        }
    }

    public function getItem($key) {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }
        else {
            throw new KeyInvalidException("Invalid key $key.");
        }
    }


    public function getItems(){
            return $this->items;
    }


}