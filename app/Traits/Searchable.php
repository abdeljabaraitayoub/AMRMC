<?php

namespace App\Traits;

trait Searchable
{
    /**
     * Search for a model based on a query.
     *
     * @param string $query The search query.
     * @return array
     */
    public static function search($query)
    {
        $elasticsearch = app('Elasticsearch\Client');
        $instance = new static;
        $items = $elasticsearch->search([
            'index' => $instance->getSearchIndex(),
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => $instance->getSearchFields() // Specify the fields to search in
                    ]
                ]
            ]
        ]);

        return array_column($items['hits']['hits'], '_source');
    }

    /**
     * Get the Elasticsearch index name.
     *
     * @return string
     */
    public function getSearchIndex()
    {
        return 'users'; // Customize to your index name
    }

    /**
     * Define the fields that should be searchable.
     *
     * @return array
     */
    public function getSearchFields()
    {
        return ['name', 'email']; // Adjust according to your model's fields
    }
    public function ensureIndexExists()
    {
        $elasticsearch = app('Elasticsearch\Client');
        $indexParams = [
            'index' => $this->getSearchIndex(),
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    'properties' => [
                        'name' => [
                            'type' => 'text'
                        ],
                        'email' => [
                            'type' => 'keyword'
                        ],
                        // Add other properties here
                    ]
                ]
            ]
        ];

        if (!$elasticsearch->indices()->exists(['index' => $this->getSearchIndex()])) {
            $elasticsearch->indices()->create($indexParams);
        }
    }
    public function index()
    {
        $this->ensureIndexExists(); // Ensure index exists before indexing

        $elasticsearch = app('Elasticsearch\Client');
        $elasticsearch->index([
            'index' => $this->getSearchIndex(),
            'id' => $this->getKey(),
            'body' => $this->toSearchArray(),
        ]);
    }
    public function toSearchArray()
    {
        // Customize the array as per the data of your User model
        return [
            'name' => $this->name,
            'email' => $this->email,
            // Add other attributes you want to index
        ];
    }
}
