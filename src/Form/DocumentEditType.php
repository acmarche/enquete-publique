<?php

namespace AcMarche\EnquetePublique\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DocumentEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('file');
    }

    public function getParent(): ?string
    {
        return DocumentType::class;
    }
}
