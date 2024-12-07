# Permission Management System

A comprehensive permission management system built for the Filament Skeleton. This system provides fine-grained access control for all your models with minimal setup required.

## Architecture

The permission system is built on several key components:

1. **BaseModel**
   - Foundation class that provides permission handling capabilities
   - Automatic CRUD permission generation
   - Permission checking methods
   - Caching integration

2. **PermissionRegistry**
   - Central registry for all permissions
   - Handles permission registration and retrieval
   - Manages permission caching

3. **Role System**
   - Role-based access control
   - Permission grouping
   - Role inheritance capabilities

## Basic Implementation

### Base Model Usage

```php
use App\Models\Base\BaseModel;

class Post extends BaseModel
{
    protected static function booted()
    {
        parent::booted();
        static::registerModelPermissions();
    }

    // Optional: Add custom permissions
    public static function getStandardPermissions(): array
    {
        return array_merge(parent::getStandardPermissions(), [
            'publish',
            'archive'
        ]);
    }

    // Optional: Custom permission name format
    public static function getPermissionName($action)
    {
        return "$action " . Str::kebab(class_basename(static::class));
    }
}
```

### Permission Checking

```php
// Direct checking
if ($post->checkPermission($user, 'update')) {
    // Proceed with update
}

// Policy integration
public function update(User $user, Post $post)
{
    return $post->checkPermission($user, 'update');
}

// Middleware usage
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->middleware('check.permission:update');
```

## Advanced Features

### Caching System

The permission system includes built-in caching:

```php
protected static function getCachedPermissions()
{
    return cache()->remember(
        static::getPermissionCacheKey(),
        config('permissions.cache_duration'),
        fn() => static::generatePermissions()
    );
}
```

### Custom Permission Actions

You can define custom actions beyond CRUD:

```php
protected static function getCustomActions(): array
{
    return [
        'publish' => [
            'label' => 'Publish',
            'description' => 'Ability to publish content'
        ],
        'archive' => [
            'label' => 'Archive',
            'description' => 'Ability to archive content'
        ]
    ];
}
```

### Role Integration

```php
class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermissionTo($permission)
    {
        return $this->permissions->contains('name', $permission);
    }
}
```

## Filament Integration

### Resource Implementation

```php
class PostResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view post');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create post');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('update post');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete post');
    }

    protected function getActions(): array
    {
        return [
            Actions\PublishAction::make()
                ->visible(fn () => auth()->user()->can('publish post')),
            Actions\ArchiveAction::make()
                ->visible(fn () => auth()->user()->can('archive post')),
        ];
    }
}
```

### Page Implementation

```php
class ListPosts extends ListRecords
{
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->visible(fn ($record) => auth()->user()->can('update post')),
            Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => auth()->user()->can('delete post')),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()->can('delete post')),
                Tables\Actions\PublishBulkAction::make()
                    ->visible(fn () => auth()->user()->can('publish post')),
            ]),
        ];
    }
}
```

## Command Line Tools

The skeleton includes several artisan commands for permission management:

```bash
# List all permissions
php artisan permissions:list

# Sync permissions for all models
php artisan permissions:sync

# Clear permission cache
php artisan permissions:clear-cache
```

## Best Practices

1. **Cache Management**
   - Use the built-in caching system
   - Clear cache after permission changes
   - Configure appropriate cache duration

2. **Role Organization**
   - Create roles based on business domains
   - Follow principle of least privilege
   - Use role inheritance where appropriate

3. **Security Considerations**
   - Always check permissions on both frontend and backend
   - Use middleware for route protection
   - Implement proper permission checking in Filament resources

4. **Performance**
   - Utilize eager loading for permissions
   - Use caching effectively
   - Optimize permission checks in loops

## Extending the System

You can extend the permission system by:

1. Creating custom permission providers
2. Adding new permission types
3. Implementing custom caching strategies
4. Adding permission inheritance
5. Creating permission groups

## Troubleshooting

### Common Issues

1. **Permissions Not Updating**
   - Clear the permission cache
   - Check if the model is properly extending BaseModel
   - Verify permission registration in boot method

2. **Performance Issues**
   - Enable permission caching
   - Review permission check frequency
   - Optimize database queries

3. **Missing Permissions**
   - Run permissions:sync command
   - Check model registration
   - Verify permission naming

### Debugging Tips

```php
// Debug permission names
Log::debug('Permission check:', [
    'model' => class_basename($this),
    'action' => $action,
    'generated_name' => static::getPermissionName($action)
]);

// Check cached permissions
Log::debug('Cached permissions:', [
    'key' => static::getPermissionCacheKey(),
    'permissions' => cache()->get(static::getPermissionCacheKey())
]);
```

## Contributing

When contributing to the permission system:

1. Add tests for new features
2. Document changes in this file
3. Follow Laravel best practices
4. Maintain backward compatibility
5. Consider performance implications