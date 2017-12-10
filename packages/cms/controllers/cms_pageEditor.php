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
class cms_pageEditor extends controller {
	
	function __construct() {
		
		$db = new mydataobj();
		$db->setconn(database::kolibriDB());
		//$db->debug(1);
		
		
		$db->query("CREATE TABLE IF NOT EXISTS categories ( idcategories INT NOT NULL AUTO_INCREMENT, categoriesName VARCHAR(45) NULL, PRIMARY KEY (idcategories)) ENGINE = InnoDB;");

				$db->query("CREATE TABLE IF NOT EXISTS tags ( idtags INT NOT NULL AUTO_INCREMENT, tagName VARCHAR(45) NULL, PRIMARY KEY (idtags)) ENGINE = InnoDB;");

				$db->query("CREATE TABLE IF NOT EXISTS page ( idpage INT NOT NULL AUTO_INCREMENT, pageName VARCHAR(45) NULL, templateName VARCHAR(45) NULL, templateCode BLOB NULL, customJavaScript BLOB NULL, customCss BLOB NULL, published INT NULL DEFAULT 0, dateCreated DATETIME NULL, dateModify DATETIME NULL, PRIMARY KEY (idpage)) ENGINE = InnoDB;");
				
				$db->query("CREATE TABLE IF NOT EXISTS content ( 
				  idcontent INT NOT NULL AUTO_INCREMENT,
				  page_idpage INT NOT NULL,
				  contentName VARCHAR(45) NULL,
				  content BLOB NULL,
				  published INT NULL DEFAULT 0,
				  dateCreated DATETIME NULL,
				  dateModify DATETIME NULL,
				  PRIMARY KEY (idcontent),
				  INDEX fk_content_page1_idx (page_idpage ASC),
				  CONSTRAINT fk_content_page1
				    FOREIGN KEY (page_idpage)
				    REFERENCES page (idpage)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION)
				ENGINE = InnoDB;");
				
				$db->query("CREATE TABLE IF NOT EXISTS content_has_categories (
				  content_idcontent INT NOT NULL,
				  categories_idcategories INT NOT NULL,
				  PRIMARY KEY (content_idcontent, categories_idcategories),
				  INDEX fk_content_has_categories_categories1_idx (categories_idcategories ASC),
				  INDEX fk_content_has_categories_content1_idx (content_idcontent ASC),
				  CONSTRAINT fk_content_has_categories_content1
				    FOREIGN KEY (content_idcontent)
				    REFERENCES content (idcontent)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				  CONSTRAINT fk_content_has_categories_categories1
				    FOREIGN KEY (categories_idcategories)
				    REFERENCES categories (idcategories)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION)
				ENGINE = InnoDB;");


				$db->query("CREATE TABLE IF NOT EXISTS content_has_tags (
				  content_idcontent INT NOT NULL,
				  tags_idtags INT NOT NULL,
				  PRIMARY KEY (content_idcontent, tags_idtags),
				  INDEX fk_content_has_tags_tags1_idx (tags_idtags ASC),
				  INDEX fk_content_has_tags_content1_idx (content_idcontent ASC),
				  CONSTRAINT fk_content_has_tags_content1
				    FOREIGN KEY (content_idcontent)
				    REFERENCES content (idcontent)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				  CONSTRAINT fk_content_has_tags_tags1
				    FOREIGN KEY (tags_idtags)
				    REFERENCES tags (idtags)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION)
						ENGINE = InnoDB;");
				
				$db->query("CREATE TABLE IF NOT EXISTS page_has_tags (
				  page_idpage INT NOT NULL,
				  tags_idtags INT NOT NULL,
				  PRIMARY KEY (page_idpage, tags_idtags),
				  INDEX fk_page_has_tags_tags1_idx (tags_idtags ASC),
				  INDEX fk_page_has_tags_page1_idx (page_idpage ASC),
				  CONSTRAINT fk_page_has_tags_page1
				    FOREIGN KEY (page_idpage)
				    REFERENCES page (idpage)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				  CONSTRAINT fk_page_has_tags_tags1
				    FOREIGN KEY (tags_idtags)
				    REFERENCES tags (idtags)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION)
				ENGINE = InnoDB;");

				$db->query("CREATE TABLE IF NOT EXISTS page_has_categories (
				  page_idpage INT NOT NULL,
				  categories_idcategories INT NOT NULL,
				  PRIMARY KEY (page_idpage, categories_idcategories),
				  INDEX fk_page_has_categories_categories1_idx (categories_idcategories ASC),
				  INDEX fk_page_has_categories_page1_idx (page_idpage ASC),
				  CONSTRAINT fk_page_has_categories_page1
				    FOREIGN KEY (page_idpage)
				    REFERENCES page (idpage)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				  CONSTRAINT fk_page_has_categories_categories1
				    FOREIGN KEY (categories_idcategories)
				    REFERENCES categories (idcategories)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION)
						ENGINE = InnoDB;");
				
						
		
	}
	
	function index() {
		
		$p = new pageModel();
		$lst = $p->listpage();
		
		$v = new cmsEditView();
		$v->pageList($lst);
		
	}
	
	
	function newPage() {
		
		$v = new cmsEditView();
		$v->newPage();
		
	}
	
}