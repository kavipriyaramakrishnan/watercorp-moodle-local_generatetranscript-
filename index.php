<?php
/**
 * Water Corporation - Contractor Induction PhaseII
 *
 * Generate Transcript PDF
 *
 * @package   local_generatetranscript
 * @author    Priya Ramakrishnan <priya@pukunui.com>, Pukunui
 * @copyright 2017 onwards, Pukunui
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../config.php');
// Main landing page, Nothing is done here.
require($CFG->dirroot.'/local/generatetranscript/locallib.php');
local_generatetranscript_pdf();
//redirect($CFG->wwwroot);