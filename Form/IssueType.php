<?php
namespace Zeichen32\GitLabApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Titel'
            ))
            ->add('description', 'textarea', array(
                'label' => 'Beschreibung'
            ))
            ->add('labels', 'text', array(
                'required' => false,
                'label' => 'Tags'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'mapped' => false,
        ));
    }

    public function getName()
    {
        return 'zeichen32_issue_type';
    }
}