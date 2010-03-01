<?php
/**
 * Quip
 *
 * Copyright 2010 by Shaun McCormick <shaun@collabpad.com>
 *
 * This file is part of Quip, a simpel commenting component for MODx Revolution.
 *
 * Quip is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Quip is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Quip; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package quip
 */
/**
 * Create a comment
 *
 * @package quip
 * @subpackage processors
 */
$errors = array();
if (empty($_POST['comment'])) $errors[] = $modx->lexicon('quip.message_err_ns');

/* sanity checks - strip out iframe/javascript */
$body = $_POST['comment'];
$body = preg_replace("/<script(.*)<\/script>/i",'',$body);
$body = preg_replace("/<iframe(.*)<\/iframe>/i",'',$body);
$body = preg_replace("/<iframe(.*)\/>/i",'',$body);
$body = strip_tags($body,$allowedTags);

$comment = $modx->newObject('quipComment');
$comment->set('body',$body);
$comment->set('thread',$scriptProperties['thread']);
$comment->set('createdon',strftime('%Y-%m-%d %H:%M:%S'));
$comment->set('username',$modx->user->get('username'));
$comment->set('author',$modx->user->get('id'));

if ($comment->save() == false) {
    $errors['message'] = $modx->lexicon('quip.comment_err_save');
}
return $errors;