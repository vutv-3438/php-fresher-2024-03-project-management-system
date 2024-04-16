<?php

namespace Tests\Unit\Models;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

abstract class BaseModel extends TestCase
{
    /**
     * @param Model $model
     * @param array $fillable
     * @param array $hidden
     * @param array $guarded
     * @param array $visible
     * @param array $casts
     * @param array $appends
     * @param array $dates
     * @param string $collectionClass
     * @param string|null $table
     * @param string $primaryKey
     * @param string|null $connection
     *
     * - `$fillable` -> `getFillable()`
     * - `$guarded` -> `getGuarded()`
     * - `$table` -> `getTable()`
     * - `$primaryKey` -> `getKeyName()`
     * - `$connection` -> `getConnectionName()`: in case multiple connections exist.
     * - `$hidden` -> `getHidden()`
     * - `$visible` -> `getVisible()`
     * - `$casts` -> `getCasts()`: note that method appends incrementing key.
     * - `$dates` -> `getDates()`: note that method appends `[static::CREATED_AT, static::UPDATED_AT]`.
     * - `newCollection()`: assert collection is exact type. Use `assertEquals` on `get_class()` result, but not `assertInstanceOf`.
     */
    protected function runConfigurationAssertions(
        Model $model,
        array $fillable = [],
        array $hidden = [],
        array $guarded = ['*'],
        array $visible = [],
        array $casts = ['id' => 'int'],
        array $appends = [],
        array $dates = ['created_at', 'updated_at'],
        string $collectionClass = Collection::class,
        ?string $table = null,
        string $primaryKey = 'id',
        ?string $connection = null
    ) {
        $this->assertEquals($fillable, $model->getFillable());
        $this->assertEquals($guarded, $model->getGuarded());
        $this->assertEquals($hidden, $model->getHidden());
        $this->assertEquals($visible, $model->getVisible());
        $this->assertEquals($casts, $model->getCasts());
        $this->assertEquals($dates, $model->getDates());
        $this->assertEquals($primaryKey, $model->getKeyName());
        foreach ($appends as $append) {
            $this->assertTrue($model->hasAppended($append));
        }

        $c = $model->newCollection();
        $this->assertEquals($collectionClass, get_class($c));
        $this->assertInstanceOf(Collection::class, $c);

        if ($connection !== null) {
            $this->assertEquals($connection, $model->getConnectionName());
        }

        if ($table !== null) {
            $this->assertEquals($table, $model->getTable());
        }
    }

    /**
     * @param HasMany $relation
     * @param Model $model
     * @param Model $related
     * @param null $key
     * @param null $parent
     * @param Closure|null $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKey()`: any `HasOneOrMany` or `BelongsTo` relation, but key type differs (see documentation).
     * - `getQualifiedParentKeyName()`: in case of `HasOneOrMany` relation, there is no `getLocalKey()` method, so this one should be asserted.
     */
    protected function assertHasOneRelation(
        HasOne $relation,
        Model $model,
        Model $related,
        $key = null,
        $parent = null,
        ?Closure $queryCheck = null
    ) {
        $this->assertInstanceOf(HasOne::class, $relation);

        if ($queryCheck !== null) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }

        if ($key === null) {
            $key = $model->getForeignKey();
        }

        $this->assertEquals($key, $relation->getForeignKeyName());

        if ($parent === null) {
            $parent = $model->getKeyName();
        }

        $this->assertEquals($model->getTable() . '.' . $parent, $relation->getQualifiedParentKeyName());
    }

    /**
     * @param $relation
     * @param Model $model
     * @param Model $related
     * @param null $key
     * @param null $parent
     * @param Closure|null $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKey()`: any `HasOneOrMany` or `BelongsTo` relation, but key type differs (see documentation).
     * - `getQualifiedParentKeyName()`: in case of `HasOneOrMany` relation, there is no `getLocalKey()` method, so this one should be asserted.
     */
    protected function assertHasRelation(
        $relation,
        Model $model,
        $key = null,
        $parent = null,
        ?Closure $queryCheck = null
    ) {
        $this->assertTrue(
            $relation instanceof HasOne || $relation instanceof  HasMany,
            'The relation must be has one or has many'
        );

        // Check query same with passed query (relation query)
        if ($queryCheck !== null) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }

        if ($key === null) {
            $key = $model->getForeignKey(); // exp: User => user_id (mark it default)
        }

        $this->assertEquals($key, $relation->getForeignKeyName());

        if ($parent === null) {
            $parent = $model->getKeyName();
        }

        $this->assertEquals($model->getTable() . '.' . $parent, $relation->getQualifiedParentKeyName());
    }

    /**
     * @param BelongsTo $relation
     * @param Model $model
     * @param Model $related
     * @param string $key
     * @param null $owner
     * @param Closure|null $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKeyName()`: any `HasOneOrMany` or `BelongsTo` relation, but key type differs (see documentation).
     * - `getOwnerKeyName()`: `BelongsTo` relation and its extending.
     */
    protected function assertBelongsToRelation(
        BelongsTo $relation,
        Model $model,
        Model $related,
        $key,
        $owner = null,
        ?Closure $queryCheck = null
    ) {
        $this->assertInstanceOf(BelongsTo::class, $relation);

        if ($queryCheck !== null) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }

        $this->assertEquals($key, $relation->getForeignKeyName());

        if ($owner === null) {
            $owner = $related->getKeyName();
        }

        $this->assertEquals($owner, $relation->getOwnerKeyName());
    }

    /**
     * @param BelongsToMany $relation
     * @param Model $model
     * @param Model|string $intermediateTable
     * @param $foreignPivotKey
     * @param $relatedPivotKey
     * @param Closure|null $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKeyName()`: any `HasOneOrMany` or `BelongsTo` relation, but key type differs (see documentation).
     * - `getOwnerKeyName()`: `BelongsTo` relation and its extending.
     */
    protected function assertBelongsToManyRelation(
        BelongsToMany $relation,
        Model $model,
        $intermediateTable,
        $foreignPivotKey,
        $relatedPivotKey,
        ?Closure $queryCheck = null
    ) {
        $this->assertInstanceOf(BelongsToMany::class, $relation);

        if ($queryCheck !== null) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }

        // Check pivot table
        $interTableName = $intermediateTable instanceof Model
            ? $intermediateTable->getTable()
            : $intermediateTable;
        $this->assertEquals($interTableName, $relation->getTable());
        $this->assertEquals(
            $interTableName . '.' . $relation->getForeignPivotKeyName(),
            $relation->getQualifiedForeignPivotKeyName()
        );
        $this->assertEquals(
            $interTableName . '.' . $relation->getRelatedPivotKeyName(),
            $relation->getQualifiedRelatedPivotKeyName()
        );

        // Check pivot key
        $this->assertEquals($foreignPivotKey, $relation->getForeignPivotKeyName());
        $this->assertEquals($relatedPivotKey, $relation->getRelatedPivotKeyName());
    }
}
