
<?php 
/**
 * Set the default values for sw item default settings. 
 */

$switem_defaults = array(
    /* Acknowledgments options */
    'acknowledgment_header' => 'Acknowledgments',
    'acknowledgment' => 'The software and data sets provided on this web site are freely available to the academic community and are in many cases open source. They are in part or in whole funded through the National Center for Research Resources (NCRR) and National Institute of General Medical Sciences (NIGMS) of the National Institutes of Health awards to the National Biomedical Computation Resource. For us to secure the funding that allows us to continue providing these software and services, we must have evidence of its utility. Thus we ask users of our software and data to acknowledge us in their publications and inform us of these publications. Please use one of the following acknowledgments and send us references to any publications, presentations, or successful funding applications that make use of the NBCR software or data sets we provide:',
    'acknowledgment_nbcr_header' => 'Please acknowledge the use of NBCR software:',
    'acknowledgment_nbcr' => '"This project was supported by grants from the National Center for Research Resources (5P41RR008605-19) and the National Institute of General Medical Sciences (8 P41 GM103426-19) from the National Institutes of Health "',
    'acknowledgment_specific_header' => 'Acknowledgment:',
    'acknowledgment_specific' => ($acknowledgment_specific? $acknowledgment_specific : ''),
    /* Disclaimer options*/
    'disclaimer_header' => 'DISCLAIMER',
    'disclaimer' => 'THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.',
    /* Software info options*/
    'sw_version_header' => 'Version:',
    'sw_version' => ($sw_version ? $sw_version : ''),
    'sw_name' => ($sw_name ? $sw_name : ''),
    'sw_description' => ($sw_description ? $sw_description : ''),
    'sw_platforms_header' => 'Platforms:',
    'sw_platforms' => ($sw_platforms ? $sw_platforms : ''),
    'sw_citation_header' => 'Citation:',
    'sw_citation_bib' => 'bibtex',
    'sw_citation_bib_link' => ($sw_citation_bib_link ? $sw_citation_bib_link : ''),
    'sw_citation_endnote' => 'endnote',
    'sw_citation_endnote_link' => ($sw_citation_endnote_link ? $sw_citation_endnote_link : ''),
    'sw_citation_plain' => 'plain text',
    'sw_citation_plain_link' => ($sw_citation_plain_link ? $sw_citation_plain_link : ''),
    'sw_license_header' => 'License',
    'sw_license' => ($sw_license ? $sw_license : ''),
    'sw_image' => ($sw_image ? $sw_image : ''),

    /* Software links options */
    'link_download' => ($link_download ? $link_download : ''),
    'link_documentation' => ($link_documentation ? $link_documentation : ''),
    'link_users_guide' => ($link_users_guide ? $link_users_guide : ''),
    'link_tutorials' => ($link_tutorials ? $link_tutorials : ''),
    'link_datasets' => ($link_datasets ? $link_datasets : ''),
    'link_mailing_lists' => ($link_mailing_lists ? $link_mailing_lists : ''),
    'link_bug_report' => ($link_bug_report ? $link_bug_report : ''),

    /* Software web service */
    'link_webservice1' => ($link_webservice1 ? $link_webservice1 : ''),
    'link_webservice2' => ($link_webservice2 ? $link_webservice2 : ''),
    'link_webservice3' => ($link_webservice3 ? $link_webservice3 : ''),
);
?>
