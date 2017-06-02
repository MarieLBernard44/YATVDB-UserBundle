<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SerieBundle\Form\ImageType;

class RegistrationFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
          ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
          ->add('firstname', null, array('label' => 'form.firstname'))
          ->add('lastname', null, array('label' => 'form.lastname'))
          ->add('birthdate', 'date', [
              'widget' => 'single_text',
              'html5' => false,
              'format' => 'dd-MM-yyyy',
              'label' => 'form.birthdate',
              'attr' => ["class" => 'js-datepicker form-control',
                         "placeholder" => 'Pick a date']
          ])
          ->add('plainPassword', 'repeated', array('type' => 'password',
                                                   'options' => array('translation_domain' => 'FOSUserBundle'),
                                                   'first_options' => array('label' => 'form.password'),
                                                   'second_options' => array('label' => 'form.password_confirmation'),
                                                   'invalid_message' => 'fos_user.password.mismatch',
                                                   ))
          ->add('profilePicture', new ImageType(), ['required' => false,
                                                    'attr' => ['class' => 'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'registration',
        ));
    }

    // BC for SF < 2.7
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function getName()
    {
        return 'fos_user_registration';
    }
}
