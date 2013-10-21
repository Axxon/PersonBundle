<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\Mailer;

use Black\Bundle\PersonBundle\Model\PersonInterface;
use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;

/**
 * Class Mailer
 *
 * @package Black\Bundle\PersonBundle\Mailer
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var
     */
    protected $config;

    /**
     * @param \Swift_Mailer          $mailer
     * @param \Twig_Environment      $twig
     * @param ConfigManagerInterface $manager
     * @param array                  $parameters
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, ConfigManagerInterface $manager, array $parameters)
    {
        $this->mailer       = $mailer;
        $this->twig         = $twig;
        $this->manager      = $manager;
        $this->parameters   = $parameters;
    }

    /**
     * @param PersonInterface $person
     * @param                 $author
     * @param                 $message
     */
    public function sendContactMessage(PersonInterface $person, $author, $message)
    {
        $template   = $this->parameters['template']['contact'];
        $property   = $this->getMailProperty();

        $context    = array(
          'subject' => 'New Message from your website',
          'message' => $message,
          'person'  => $person,
          'author'  => $author instanceof PersonInterface ? $author->getProfile()->getName() : $author->getUsername(),
          'footer'  => $property['mail_footer_note']
        );

        $author = $author instanceof PersonInterface ? $author->getProfile()->getEmail() : $property['mail_noreply'];

        $this->sendMessage($template, $context, $author, $person->getEmail());
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendMessage($templateName, $context, $fromEmail, $toEmail)
    {
        $template   = $this->twig->loadTemplate($templateName);
        $subject    = $template->renderBlock('subject', $context);
        $textBody   = $template->renderBlock('body_text', $context);
        $htmlBody   = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($fromEmail)
                ->setTo($toEmail);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                    ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }

    /**
     * @return mixed
     */
    protected function getMailProperty()
    {
        $property = $this->manager->findPropertyByName('Mail');

        return $property->getValue();
    }
}
