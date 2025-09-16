<?php

namespace App\Enums\Candidate\Education;

enum DegreeEnum: string
{
    case SCHOOL = 'school';
    case LYCEUM = 'lyceum';
    case COLLEGE = 'college';
    case TECHNICAL_SCHOOL = 'technical_school';
    case BACHELOR = 'bachelor';
    case MAGISTRATE = 'magistrate';
    case DOCTORATE = 'doctorate';
    case POSTGRADUATE = 'postgraduate';

}
