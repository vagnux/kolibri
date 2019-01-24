<?php

/*
 * Copyright (C) 2016 Vagner Rodrigues
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */
class siteConfigModel
{

    private $chave;

    private $value;

    function setchave($value)
    {
        $this->chave = $value;
    }

    function getchave()
    {
        return $this->chave;
    }

    function setvalue($value)
    {
        $this->value = $value;
    }

    function getvalue()
    {
        return $this->value;
    }

    function listsiteConfig()
    {
        $db = new mydataobj();
        $db->setconn(database::kolibriDB());
        $db->settable("siteConfig");
        // $db->addkey("ativo", 1);
        $i = 0;
        while ($db->getchave()) {
            $out[$db->getchave()] = strtolower($db->getvalue());

            $db->next();
            $i ++;
        }
        return $out;
    }

    function load($chave)
    {
        $db = new mydataobj();
        $db->setconn(database::kolibriDB());
        $db->debug(1);
        $db->settable("siteConfig");
        // $db->addkey("ativo", 1);
        $db->addkey("chave", $chave);
        $this->setchave($db->getchave());
        $this->setvalue($db->getvalue());
    }

    function save()
    {
        $db = new mydataobj();
        $db->setconn(database::kolibriDB());
        $db->settable("siteConfig");
        $db->debug(1);
        if ($this->chave) {
            $db->addkey("chave", $this->chave);
        }
        $db->setchave($this->getchave());
        $db->setvalue($this->getvalue());
        $db->save();
        #return $db->getlastinsertid();
    }
}
