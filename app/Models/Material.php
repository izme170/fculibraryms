<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';
    protected $primaryKey = 'material_id';
    protected $fillable = [
        'isbn',
        'issn',
        'title',
        'type_id',
        'publisher_id',
        'publication_year',
        'edition',
        'volume',
        'pages',
        'size',
        'includes',
        'references',
        'bibliography',
        'description',
        'category_id',
        'material_image',
        'is_archived'
    ];

    public function materialType(){
        return $this->belongsTo(MaterialType::class, 'type_id');
    }

    public function materialCopies(){
        return $this->hasMany(MaterialCopy::class, 'material_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function publisher(){
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function authors(){
        return $this->belongsToMany(Author::class, 'material_authors', 'material_id', 'author_id');
    }

    public function editors(){
        return $this->belongsToMany(Editor::class, 'material_editors', 'material_id', 'editor_id');
    }

    public function illustrators(){
        return $this->belongsToMany(Illustrator::class, 'material_illustrators', 'material_id', 'illustrator_id');
    }
    public function subjects(){
        return $this->belongsToMany(Subject::class, 'material_subjects', 'material_id', 'subject_id');
    }
    public function translators(){
        return $this->belongsToMany(Translator::class, 'material_translators', 'material_id', 'translator_id');
    }
}
