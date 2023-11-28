<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texte', \Trsteel\CkeditorBundle\Form\Type\CkeditorType::class, array(
                'transformers'                 => array('html_purifier'),
                'toolbar'                      => array('document','basicstyles'),
                'toolbar_groups'               => array(
                    'document' => array('Source')
                ),
                'ui_color'                     => '#ffffff',
                'startup_outline_blocks'       => false,
                'width'                        => '50%',
                'height'                       => '320',
                'language'                     => 'fr_fr',
                'filebrowser_image_browse_url' => array(
                    'url' => 'relative-url.php?type=file',
                ),
            ))
            ->add('Titre', \Trsteel\CkeditorBundle\Form\Type\CkeditorType::class, array(
                'transformers'                 => array('html_purifier'),
                'toolbar'                      => array('document','basicstyles'),
                'toolbar_groups'               => array(
                    'document' => array('Source')
                ),
                'ui_color'                     => '#ffffff',
                'startup_outline_blocks'       => false,
                'width'                        => '50%',
                'height'                       => '320',
                'language'                     => 'fr_fr',
                'filebrowser_image_browse_url' => array(
                    'url' => 'relative-url.php?type=file',
                ),
            ))
            ->add('utilisateur')
            ->add('categorie')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
