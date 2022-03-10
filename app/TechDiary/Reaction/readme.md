## Techdiary Reaction


**Example 1**
Make Article model reactionable

```php
class Article extends Model implements ReactableInterface{

    use \App\TechDiary\Reaction\Traits\ReactionableModel;

}


$article->vote('REACTION_NAME', $user1);
```