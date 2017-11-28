<?php
/**
 * Water Corporation - Contractor Induction PhaseII
 *
 * Generate Transcript PDF - Library functions
 *
 * @package   local_generatetranscript
 * @author    Priya Ramakrishnan <priya@pukunui.com>, Pukunui
 * @copyright 2017 onwards, Pukunui
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 /**
 * To create certificate extracting information from transcript table.
 *
 * @uses $DB
 * @param integer $trid
 */
function local_generatetranscript_pdf() {
    global $DB, $CFG, $USER;

    require_once("$CFG->libdir/pdflib.php");
	$certificatename = 'Certificate_transcript.pdf';
	$pdf = new TCPDF('p', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle($certificatename);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(false, 0);
    $pdf->AddPage();

    // Add text.
    $font = 'helvetica';
    $size = '15';
    $syle = '';
    $pdf->SetTextColor(34, 66, 111);
    $pdf->SetFillColor(190, 190, 190);
    
    $x = 10;
    $y = 0;
    $pdf->setFont($font, '', 20);
    $img = "/home/water2/www/local/generatetranscript/pix/completion_transcript_v3_portrait.png";
    $pdf->Image($img, 0, 0, 210, 290, '', '', '', true, 70, '', false, false, 0);
  
    $pdf->writeHTMLCell(0, 0, 20, 40, get_string('title', 'local_generatetranscript'), 0, 0, 1, true, 'C');
    $pdf->setFont($font, '', 14);
    $pdf->writeHTMLCell(0, 0, 20, 50, get_string('titledesc', 'local_generatetranscript'), 0, 0, 1, true, 'C');
    
    //$pdf->SetTextColor(226, 42, 36);
    $pdf->setFont($font, '', 18);
    $pdf->writeHTMLCell(0, 0, 20, 60, fullname($USER), 0, 0, 1, true, 'C');
    
    $pdf->SetTextColor(34, 66, 111);
    $pdf->setFont($font, '', 18);
    $pdf->writeHTMLCell(0, 0, 15, 70, get_string('contractorinduction', 'local_generatetranscript'), 0, 0, 1, true, 'C');
    
    //$pdf->SetTextColor(226, 42, 36);
    $pdf->setFont($font, '', 18);
    $pdf->writeHTMLCell(0, 0, 125, 70, $USER->username, 0, 0, 1, true, 'C');
    
    $table = "<table border='0'>
              <tr>
              <td width=\"70%\"><font color=rgb(34, 66, 111)><b>".get_string('course', 'local_generatetranscript'). "</b></font></td>
              <td align='center'><font color=rgb(34, 66, 111)><b>".get_string('completed', 'local_generatetranscript'). "</b></font></td>
              </tr>
              </table>";
    $pdf->SetXY(10, 90);
    $pdf->SetTextColor(34, 66, 111);
    $pdf->writeHTML($table, true, false, false, false, '');
    $pdf->SetXY(10, 98);
    $pdf->writeHTML("<hr>", true, false, false, false, '');
    
    // Get the data for the transcript.
    $transcriptrecords = $DB->get_records_sql("SELECT CONCAT(ct.courseid, ct.cert_issue_id), ct.coursename, FROM_UNIXTIME(ct.coursecompleted, '%d %b %Y') as timecompleted, FROM_UNIXTIME(ct.cert_issue_date,'%d %b %Y') as cert_issue_date, cert_code FROM {certificate_transcript_bkp} ct WHERE ct.userid = $USER->id ORDER BY 1, 2");
    
    
    $table2 = '<table border="0">';
    foreach ($transcriptrecords as $tr) {
        $table2 .= "<tr>
                     <td width=\"70%\"><font color=rgb(226, 42, 36)>".$tr->coursename."</font></td>
                     <td align='center'><font color=rgb(226, 42, 36)>".$tr->timecompleted."</font></td>
                    </tr>";
    }
    
    $table2 .= "</table>";
    $pdf->SetXY(10, 105);
    $pdf->setFont($font, '', 12);
    $pdf->writeHTML($table2, true, false, false, false, '');
    $pdf->writeHTML("<hr>", true, false, false, false, '');
    $pdf->SetTextColor(34, 66, 111);
    $pdf->write(10, "End of Transcript");
	$pdf->Output($certificatename, 'I');
}
