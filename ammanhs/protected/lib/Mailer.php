<?php

class Mailer
{	
    /**
     * @uses This function can handle Multi part emails html/text
     *       you can send an array with the two parts in the body (array(html=>'<b>Message</b>',text=>'plain text'))
     *       or you can send normal HTML and the mailer will parse it to get out html body and text
     *       <ul>
     *           <li>Body Parts: an mixed variable conains the Text to be send in the email</li>
     *           <li>List Options:</li>
     *           <li>html : the part appears on HTML supported email clients</li>
     *           <li>text : This part appears on Email clients withno HTML support od HTML disabled</li>
     *       </ul>
     * 
     * @param string $to
     * @param string $subject
     * @param mixed $body
     * @param string $from=null
     * @param array $header=array()
     */
    public static function send($to, $subject, $body, $from=null, $headers=array())
    {
        if(is_array($body)){
            $body_html=$body['html'];
            $body_text=$body['text'];
        }else{
            $body_html=$body;
            $body_text=preg_replace('/<br\s+?\/?>/', "\n", strip_tags($body, '<br>'));
        }

        $mime_boundary="----AmmanHS----".md5(time());

        // Subject
        if($subject===null) $subject="default subject";
        $subject='=?UTF-8?B?'.base64_encode($subject).'?=';

        // Body Text
        $message="--{$mime_boundary}\n";
        $message.="Content-Type: text/plain; charset=UTF-8\n";
        $message.="Content-Transfer-Encoding: 8bit\n\n";
        $message.=$body_text;
        $message.="\n\n";

        // Body Html
        $message.="--{$mime_boundary}\n";
        $message.="Content-Type: text/html; charset=UTF-8\n";
        $message.="Content-Transfer-Encoding: 8bit\n\n";
        $message.=$body_html;
        $message.="\n\n";
        $message.="--{$mime_boundary}--\n\n";

        // From
        if($from===null) $from=Yii::app()->params['support_email'];

        // Headers
        $headers_a=$headers;
        $headers="MIME-Version: 1.0\n";
        $headers.="Content-Type: multipart/alternative; boundary=\"{$mime_boundary}\"\n";
        foreach($headers_a as $k=>$v) $headers.="$k: $v\n";
        $headers.="From: $from\n";

        $r=mail($to, $subject, $message, $headers);
        return $r;
    }

    static public function sendTemplatedEmail($to, $subject, $view, $data=array(), $with_layout=true, $from=null, $headers=array(), $utms='?utm_source=AmmanHSEmail&utm_medium=Email&utm_campaign=AmmanHSEmail')
    {
        if(!array_key_exists('utms', $data)) $data['utms']=$utms;
        $body=Yii::app()->getController()->renderPartial("/emailTemplates/$view", $data, true);
        if($with_layout)
            $body=Yii::app()->getController()->renderPartial("/emailTemplates/layout", array('content'=>$body), true);
        Mailer::send($to, $subject, $body, $from, $headers);
    }

}
