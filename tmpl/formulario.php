<?php 
defined('_JEXEC') or die;

use Joomla\CMS\Session\Session;

$token = Session::getFormToken();
?>

<form id="microservicios-form">
    <label for="microservicios-select">Select:</label>
    <select id="microservicios-select" name="microservicios_select">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
    </select>

    <fieldset>
        <legend>Microservicios:</legend>
        <label for="microservicios-checkbox1">Checkbox 1</label>
        <input type="checkbox" id="microservicios" name="microservicios_checkboxes[]" value="checkbox1">
        <label for="microservicios-checkbox2">Checkbox 2</label>
        <input type="checkbox" id="microservicios" name="microservicios_checkboxes[]" value="checkbox2">
    </fieldset>

    <label for="microservicios-input">Texto:</label>
    <input type="text" id="microservicios-input" name="microservicios-input">

    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
    <input type="hidden" name=<?php echo $token; ?> value="1"/>
    <button type="submit">Submit</button>
</form>
