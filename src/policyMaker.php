<?php

/**
 *
 * @package    policyMaker
 * @version    Release: 1.0.1
 * @license    GPL3
 * @author     Ali YILMAZ <aliyilmaz.work@gmail.com>
 * @category   Access policy generator
 * @link       https://github.com/aliyilmaz/policyMaker
 *
 */
class policyMaker extends Mind
{
    public $policy = [
        'allow'=>[],
        'deny'=>[]
    ];

    public function setAllow($allow = null){
        if(is_null($allow)) { $this->policy['allow'] = [];}
        if(!is_array($allow) AND !is_null($allow)) { $this->policy['allow'] = array($allow);}
        if(is_array($allow)) { $this->policy['allow'] = $deny;}
        return $this;
    }

    public function setDeny($deny = null){
        if(is_null($deny)) { $this->policy['deny'] = [];}
        if(!is_array($deny) AND !is_null($deny)) { $this->policy['deny'] = array($deny);}
        if(is_array($deny)) { $this->policy['deny'] = $deny;}
        return $this;
    }

    public function policyMaker(){

        $policy = [];

        switch (self::aliyilmaz('getSoftware')->getSoftware()) {
            case ('Apache' || 'LiteSpeed'):

                $policy = array(
                    'filename'=>'.htaccess',
                    'content_public'=> implode("\n", array(
                        'RewriteEngine On',
                        'RewriteCond %{REQUEST_FILENAME} -s [OR]',
                        'RewriteCond %{REQUEST_FILENAME} -l [OR]',
                        'RewriteCond %{REQUEST_FILENAME} -d',
                        'RewriteRule ^.*$ - [NC,L]',
                        'RewriteRule ^.*$ index.php [NC,L]'
                    )),
                    'content_deny'=> 'Deny from all',
                    'content_allow'=> 'Allow from all'
                );

            break;
            case 'Microsoft-IIS':

                $policy = array(
                    'filename'=>'web.config',
                    'content_public'=> implode("\n", array(
                        "<?xml version=\"1.0\" encoding=\"UTF-8\"?>",
                        "<configuration>",
                            "\t<system.webServer>",
                                "\t\t<rewrite>",
                                "\t\t\t<rules>",
                                    "\t\t\t\t<rule name=\"Imported Rule 1\" stopProcessing=\"true\">",
                                    "\t\t\t\t\t<match url=\"^(.*)$\" ignoreCase=\"false\" />",
                                    "\t\t\t\t\t<conditions>",
                                    "\t\t\t\t\t\t<add input=\"{REQUEST_FILENAME}\" matchType=\"IsFile\" ignoreCase=\"false\" negate=\"true\" />",
                                    "\t\t\t\t\t\t<add input=\"{REQUEST_FILENAME}\" matchType=\"IsDirectory\" ignoreCase=\"false\" negate=\"true\" />",
                                    "\t\t\t\t\t</conditions>",
                                    "\t\t\t\t\t<action type=\"Rewrite\" url=\"index.php\" appendQueryString=\"true\" />",
                                "\t\t\t\t</rule>",
                                "\t\t\t</rules>",
                                "\t\t</rewrite>",
                           "\t</system.webServer>",
                        '</configuration>'
                    )),
                    'content_deny'=> implode("\n", array(
                        "<authorization>",
                        "\t<deny users=\"?\"/>",
                        "</authorization>"
                    )),
                    'content_allow'=> implode("\n", array(
                        "<configuration>",
                        "\t<system.webServer>",
                        "\t\t<directoryBrowse enabled=\"true\" showFlags=\"Date,Time,Extension,Size\" />",
                        "\t\t\t</system.webServer>",
                        "</configuration>"
                    ))
                );

            break;
        }

        // Defining write package to file
        $politician = self::aliyilmaz('write');

        // The route policy is being created.
        if(!file_exists($policy['filename'])){
            $politician->write($policy['content_public'], $policy['filename']); }
        
        // The directories are determined.
        foreach (array_filter(glob('*'), 'is_dir') as $dir) {
            
            // Default policy content
            $content = $policy['content_deny'];
            
            // Checking server policy file existence.
            if(!file_exists($dir.'/'.$policy['filename'])){

                // If it's a allowed directory, the policy is assigned.
                if(in_array($dir, $this->policy['allow'])) { 
                    $content = $policy['content_allow']; }

                // If both allowed and disallowed directories conflict, 
                // an access block policy is assigned.
                if(!empty(array_intersect($this->policy['allow'], $this->policy['deny']))){
                    $content = $policy['content_deny']; }

                // The policy file is created.
                $politician->write($content, $dir.'/'.$policy['filename']);
            }
                
        }
    }

}
