<?php

namespace App\Models\Cms;

use App\Models\User\UserAsset;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;
use DB;
use Storage;
use Carbon\Carbon;
use App\Models\DeployModel;

/**
 * Asset
 */
class Asset extends DeployModel
{

    /**
     * Deploy category
     *
     * @var string
     */
    public static $deployCategory = 'assets';

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 3;

    /**
     * Possible deploy directions
     *
     * @var array
     */
    public static $deployDirections = [
        'dev-stage',
        'stage-live',
    ];

    /**
     * Default values
     *
     * @var array
     */
    protected $attributes = [
        'cash_price'  => 0,
        'coins_price' => 9000,
        'name'        => 'Untitled item',
    ];

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'created_by',
        'updated_by',
        'name',
        'cash_price',
        'coins_price',
        'type',
        'subtype',
        'action_type_id',
        'sell_status',
        'preview_url',
        'version',
        'collection_number',
        'created_at',
        'sort_order',
    ];

    /**
     * Deploy ignore fields
     *
     * @var array
     */
    private $deployIgnoreFields = [
        'stage' => [
            'name',
            'cash_price',
            'coins_price',
        ],
    ];

    const ASSET_TYPE_FURNITURE       = 1;
    const ASSET_TYPE_CLOTHES         = 2;
    const ASSET_TYPE_BANNER          = 3;
    const ASSET_TYPE_LINKED          = 4;
    const ASSET_TYPE_BODY_PART       = 5;
    const ASSET_TYPE_COLLECTION_ITEM = 6;
    const ASSET_TYPE_FOOD_ITEM       = 7;
    const ASSET_TYPE_MEAL            = 8;

    const ASSET_TYPE_ALIASES = [
        self::ASSET_TYPE_FURNITURE       => 'furniture',
        self::ASSET_TYPE_CLOTHES         => 'clothes',
        self::ASSET_TYPE_BANNER          => 'banner',
        self::ASSET_TYPE_LINKED          => 'linked',
        self::ASSET_TYPE_BODY_PART       => 'body_part',
        self::ASSET_TYPE_COLLECTION_ITEM => 'collection_item',
        self::ASSET_TYPE_FOOD_ITEM       => 'food_item',
        self::ASSET_TYPE_MEAL            => 'meal',
    ];

    const FILES_FOLDER = 'Assets/Preview';


    /**
     * TrophyCupConfig constructor.
     *
     * @param array $attributes Attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = environment() . '.' . self::DB_CONNECTION;
    }

    /**
     * Boot
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // create a event to happen on updating
        static::updating(function ($table) {
            if (Auth::user()) {
                $table->updated_by = Auth::user()->id;
            }
        });

        // create a event to happen on saving
        static::saving(function ($table) {
            if (Auth::user()) {
                $table->created_by = Auth::user()->id;
                $table->updated_by = Auth::user()->id;
            }
        });
    }

    /**
     * Get upload folder
     *
     * @param string $env Env
     *
     * @return string
     */
    protected static function getUploadFolder(?string $env = null): string
    {
        if (!$env) {
            $env = environment();
        }
        return $env . '/' . self::FILES_FOLDER;
    }

    /**
     * Create or update asset's bundle files
     *
     * @return void
     */
    public function makeBundleFiles()
    {
        if (!empty($this->type)) {
            $assetFilePath = config("presets.asset_file_path");

            foreach ($this->bundles as $bundle) {
                if (!Storage::exists($bundle->url)) {
                    continue;
                }
                    
                // $path = "Assets/" . self::ASSET_TYPE_ALIASES[$this->type] . "/{$assetFilePath[$bundle->type]}";
                $path = $this->getAssetBundlePath($assetFilePath[$bundle->type]);

                /**
                 * {AssetID}_{AssetVersion}
                 */
                $assetBundleName = $this->getAssetBundleName();

                /**
                 * Looks like: a1/b2/c3
                 */
                $assetSubFolder = getSubFolder($assetBundleName);

                $file = "{$path}/{$assetSubFolder}/{$assetBundleName}";

                if (!Storage::exists($file)) {
                    /**
                     * Remove old version
                     */
                    if ($this->version > 1) {
                        $version           = $this->version - 1;
                        $oldAssetName      = "{$this->id}_{$version}";
                        $oldAssetSubFolder = getSubFolder($oldAssetName);
                        $oldFile           = "{$path}/{$oldAssetSubFolder}/{$oldAssetName}";
                        if (Storage::exists($oldFile)) {
                            Storage::delete($oldFile);
                        }
                    }

                    /**
                     * Copy ADP file with bundle to asset
                     */
                    Storage::copy($bundle->url, $file);
                }
            }
        }
    }

    /**
     * Get asset bundle name
     * {AssetID}_{AssetVersion}
     *
     * @return string
     */
    public function getAssetBundleName()
    {
        return "{$this->id}_{$this->version}";
    }

    /**
     * Get asset bundle path
     *
     * @param string $bundleTypePath BundleTypePath
     * @param string $env            Env
     *
     * @return string
     */
    public function getAssetBundlePath(string $bundleTypePath, string $env = '')
    {
        if (!$env) {
            $env = environment();
        }

        $path = $env . "/Assets/" . self::ASSET_TYPE_ALIASES[$this->type] . "/$bundleTypePath";

        return $path;
    }

    /**
     * CmsUser relation. Created By
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(CmsUser::class, 'created_by');
    }

    /**
     * NLA Assets relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nlaAssets()
    {
        return $this->hasOne(NlaAsset::class, 'asset_id');
    }

    /**
     * CmsUser relation. Updated By
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(CmsUser::class, 'updated_by');
    }

    /**
     * Subtype relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assetSubtype()
    {
        return $this->belongsTo(Subtype::class, 'subtype');
    }

    /**
     * UserAsset relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAssets()
    {
        return $this->hasMany(UserAsset::class);
    }

    /**
     * Award relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function awards()
    {
        return $this->hasMany(Award::class);
    }

    /**
     * AssetLocalization relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assetLocalizations()
    {
        return $this->hasMany(AssetLocalization::class);
    }

    /**
     * ShopItem relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopItems()
    {
        return $this->hasMany(ShopItem::class);
    }

    /**
     * Cert
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cert()
    {
        return $this->hasOne(Certificate::class, 'asset_id');
    }
    
    /**
     * Attribute relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assetAttributes()
    {
        return $this->belongsToMany(Attribute::class, 'asset_attributes')->withPivot('value');
    }

    /**
     * AssetActionTypeState relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assetStateAward()
    {
        return $this->hasMany(AssetActionTypeState::class);
    }

    /**
     * ActionType relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function actionType()
    {
        return $this->hasOne(ActionType::class, 'id', 'action_type_id');
    }

    /**
     * AssetActionTypeAttribute relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assetActionTypeAttributes()
    {
        return $this->hasMany(AssetActionTypeAttribute::class, 'asset_id');
    }

    /**
     * Belongs to shops
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function belongsToShops()
    {
        return $this->belongsToMany(
            Shop::class,
            'shop_items',
            'asset_id',
            'shop_id',
            'id',
            'id'
        )->distinct('shop_id');
    }

    /**
     * Delete
     *
     * @return boolean|null|void
     * @throws \Exception Can't delete
     */
    public function delete()
    {
        FileService::delete($this->preview_url);
        parent::delete();
    }

    /**
     * Update asset attribute
     *
     * @param integer $assetID     Asset ID
     * @param integer $attributeID Attribute ID
     * @param mixed   $value       Attribute Value
     *
     * @return void
     */
    public static function attributeUpdate(int $assetID, int $attributeID, $value)
    {
        $sql = "
            INSERT INTO asset_attributes (`asset_id`, `attribute_id`, `value`)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)";

        DB::insert($sql, [
            $assetID,
            $attributeID,
            $value,
        ]);
    }

    /**
     * Get last collection number (Collection ID)
     *
     * @return integer
     */
    public static function getLastCollectionNumber()
    {
        return (int) DB::table('assets')->max('collection_number');
    }

    /**
     * Has Gift wrap
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function giftWrap()
    {
        return $this->hasOne(AssetGiftWrap::class, 'asset_id', 'id');
    }

    /**
     * Deploy
     *
     * @param string $fromEnv From env
     * @param string $toEnv   To env
     *
     * @return boolean
     */
    public function deploy(string $fromEnv, string $toEnv)
    {
        $status = false;
        if ($this->checkDirection($fromEnv, $toEnv)) {
            $destinationDatabase = DB::connection("$toEnv.cms");
            $this->setConnection("$fromEnv.cms");

            $now = Carbon::now();



            $builder = $this->where(function ($query) {
                $query->whereRaw('deployed_at < updated_at')
                    ->orWhereNull('deployed_at');
            })->whereNotNull('type');

            $assetFilesPath = config("presets.asset_file_path");

            foreach ($builder->get() as $asset) {
                $destinationAssetVersion = 0;


                if ($toEnv == 'stage') {
                    $destinationAssetVersion = $destinationDatabase->table('assets')
                        ->where('id', $asset->id)
                        ->value('version');
                }

                $asset->deployed_at = null;
                $asset->updated_at  = $now;
                $assetData          = $asset->toArray();

                /**
                 * Unset fields for particular env
                 */
                $ignoreFields = $this->deployIgnoreFields[$toEnv] ?? [];
                foreach ($ignoreFields as $ignoreField) {
                    unset($assetData[$ignoreField]);
                }

                /**
                 * Deploy preview file
                 */
                $destinationPreview       = $this->deployPreview($asset->id, $assetData['preview_url'], $fromEnv, $toEnv);
                $assetData['preview_url'] = $destinationPreview;

                if ($assetData['type'] === self::ASSET_TYPE_BODY_PART) {
                    $assetData['cash_price']  = 0;
                    $assetData['coins_price'] = 0;
                }
                /**
                 * Deploy db data
                 */
                self::on("$toEnv.cms")->updateOrCreate(['id' => $asset->id], $assetData);

                /**
                 * Deploy giftWrap
                 */
                if ($asset->giftWrap) {
                    $rowData = $asset->giftWrap->toArray();
                    $query   = [
                        'asset_id' => $rowData['asset_id'],
                    ];
                    $destinationDatabase->table('asset_gift_wraps')->updateOrInsert($query, $rowData);
                }

                /**
                 * Deploy assetAttributes
                 */
                foreach ($asset->assetAttributes as $assetAttribute) {
                    if (($toEnv == 'stage' && $assetAttribute->deployable_to_stage)
                        || ($toEnv == 'dev' && $assetAttribute->deployable_to_dev)
                        || $toEnv == 'live'
                    ) {
                        $rowData    = $assetAttribute->relations['pivot']->toArray();
                        $pivotTable = $assetAttribute->relations['pivot']->table;
                        $query      = [
                            'asset_id'     => $rowData['asset_id'],
                            'attribute_id' => $rowData['attribute_id'],
                        ];

                        $destinationDatabase->table($pivotTable)->updateOrInsert($query, $rowData);
                    }
                }

                /**
                 * Deploy assetActionTypeAttribute
                 */
                foreach ($asset->assetActionTypeAttributes as $assetActionTypeAttribute) {
                    if (($toEnv == 'stage' && $assetActionTypeAttribute->deployable_to_stage)
                        || ($toEnv == 'dev' && $assetActionTypeAttribute->deployable_to_dev)
                        || $toEnv == 'live'
                    ) {
                        $rowData = $assetActionTypeAttribute->toArray();
                        $query   = [
                            'asset_id'                 => $rowData['asset_id'],
                            'action_type_state_id'     => $rowData['action_type_state_id'],
                            'action_type_attribute_id' => $rowData['action_type_attribute_id'],
                        ];

                        $destinationDatabase->table('asset_action_type_attributes')->updateOrInsert($query, $rowData);
                    }
                }

                /**
                 * Deploy dyes
                 */
                if ($asset->dye) {
                    $rowData = $asset->dye->toArray();
                    $query   = [
                        'asset_id' => $rowData['asset_id'],
                    ];
                    $destinationDatabase->table('dyes')->updateOrInsert($query, $rowData);
                }

                /**
                 * Deploy files
                 */
                foreach ($assetFilesPath as $assetFilePath) {
                    $sourcePath      = $asset->getAssetBundlePath($assetFilePath, $fromEnv);
                    $destinationPath = $asset->getAssetBundlePath($assetFilePath, $toEnv);
                    $assetBundleName = $asset->getAssetBundleName();
                    $assetSubFolder  = getSubFolder($assetBundleName);
                    $sourceFile      = "{$sourcePath}/{$assetSubFolder}/{$assetBundleName}";
                    $destinationFile = "{$destinationPath}/{$assetSubFolder}/{$assetBundleName}";

                    /**
                     * Delete old version of asset bundle file. Only for STAGE!
                     */
                    if ($toEnv == 'stage' && $destinationAssetVersion) {
                        $oldAssetBundleName = "{$asset->id}_{$destinationAssetVersion}";
                        $oldAssetSubFolder  = getSubFolder($oldAssetBundleName);
                        $oldAssetFile       = "{$destinationPath}/{$oldAssetSubFolder}/{$oldAssetBundleName}";

                        if (Storage::exists($oldAssetFile)) {
                            Storage::delete($oldAssetFile);
                        }
                    }

                    if (Storage::exists($sourceFile) && !Storage::exists($destinationFile)) {
                        Storage::copy($sourceFile, $destinationFile);
                    }
                }
            }

            /**
             * Turn off auto updated_at
             */
            $this->timestamps = false;
            $builder->update(['deployed_at' => $now]);
            $status = true;
        }
        return $status;
    }

    /**
     * Get number of rows for deploy
     *
     * @return integer
     */
    public function rowsForDeploy()
    {
        return $this->select(DB::raw('count(*) as total'))->where(function ($query) {
            $query->whereRaw('deployed_at < updated_at')
                ->orWhereNull('deployed_at');
        })->whereNotNull('type')->first()->total;
    }

    /**
     * Deploy preview file
     *
     * @param integer $id       Asset id
     * @param string  $fileName File name
     * @param string  $fromEnv  From env
     * @param string  $toEnv    To env
     *
     * @return string
     */
    protected function deployPreview(int $id, string $fileName, string $fromEnv, string $toEnv)
    {
        $deployedFile = '';
        if ($fileName) {
            $fileFolder = static::getUploadFolder($fromEnv);

            $destinationFileFolder = static::getUploadFolder($toEnv);
            $destinationFile       = str_replace($fileFolder, $destinationFileFolder, $fileName);

            if (Storage::exists($fileName) && !Storage::exists($destinationFile)) {
                Storage::copy($fileName, $destinationFile);
            }
            $deployedFile = $destinationFile;
        }
        return $deployedFile;
    }
}
