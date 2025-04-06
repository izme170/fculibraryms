<?php

namespace App\Imports;

use App\Models\Author;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Editor;
use App\Models\FundingSource;
use App\Models\Illustrator;
use App\Models\Material;
use App\Models\MaterialCopy;
use App\Models\MaterialType;
use App\Models\Publisher;
use App\Models\Subject;
use App\Models\Translator;
use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MaterialImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $type = MaterialType::firstOrCreate(['name' => $row['type']]);
        $publisher = Publisher::firstOrCreate(['name' => $row['publisher']]);
        $category = Category::firstOrCreate(['category' => $row['category']]);
        $dateAcquired = $row['date_acquired'];

        if (is_numeric($dateAcquired)) {
            $dateAcquired = Date::excelToDateTimeObject($dateAcquired);
        } else {
            $dateAcquired = Carbon::parse($dateAcquired);
        }

        // Look for existing material by title + publisher
        $material = Material::where('title', $row['title'])
            ->where('publisher_id', $publisher->publisher_id)
            ->first();

        if (!$material) {
            $material = Material::create([
                'isbn'              => $row['isbn'],
                'issn'              => $row['issn'],
                'title'             => $row['title'],
                'type_id'           => $type->type_id,
                'publisher_id'      => $publisher->publisher_id,
                'publication_year'  => $row['publication_year'],
                'edition'           => $row['edition'],
                'volume'            => $row['volume'],
                'pages'             => $row['pages'],
                'size'              => $row['size'],
                'includes'          => $row['includes'],
                'references'        => $row['references'],
                'bibliography'      => $row['bibliography'],
                'description'       => $row['description'],
                'category_id'       => $category->category_id
            ]);

            // Sync relations only on new material
            $this->syncRelations($row, $material);
        }

        // Create Material Copy regardless
        $vendor = Vendor::firstOrCreate(['name' => $row['vendor'] ?? 'Unknown']);
        $funding = FundingSource::firstOrCreate(['name' => $row['funding_source'] ?? 'Unknown']);
        $condition = Condition::firstOrCreate(['name' => $row['condition'] ?? 'Good']);

        MaterialCopy::create([
            'material_id'     => $material->material_id,
            'copy_number'     => $row['copy_number'],
            'accession_number' => $row['accession_number'],
            'call_number'     => $row['call_number'],
            'price'           => $row['price'],
            'vendor_id'       => $vendor->vendor_id,
            'fund_id' => $funding->fund_id,
            'notes'           => $row['notes'],
            'condition_id'    => $condition->condition_id,
            'date_acquired'   => $dateAcquired
        ]);

        return $material;
    }

    private function syncRelations(array $row, Material $material)
    {
        if (!empty($row['authors'])) {
            $authorIds = collect(explode(',', $row['authors']))
                ->map(fn($name) => Author::firstOrCreate(['name' => trim($name)])->author_id);
            $material->authors()->sync($authorIds);
        }

        if (!empty($row['editors'])) {
            $editorIds = collect(explode(',', $row['editors']))
                ->map(fn($name) => Editor::firstOrCreate(['name' => trim($name)])->editor_id);
            $material->editors()->sync($editorIds);
        }

        if (!empty($row['illustrators'])) {
            $illustratorIds = collect(explode(',', $row['illustrators']))
                ->map(fn($name) => Illustrator::firstOrCreate(['name' => trim($name)])->illustrator_id);
            $material->illustrators()->sync($illustratorIds);
        }

        if (!empty($row['subjects'])) {
            $subjectIds = collect(explode(',', $row['subjects']))
                ->map(fn($name) => Subject::firstOrCreate(['name' => trim($name)])->subject_id);
            $material->subjects()->sync($subjectIds);
        }

        if (!empty($row['translators'])) {
            $translatorIds = collect(explode(',', $row['translators']))
                ->map(fn($name) => Translator::firstOrCreate(['name' => trim($name)])->translator_id);
            $material->translators()->sync($translatorIds);
        }
    }
}
