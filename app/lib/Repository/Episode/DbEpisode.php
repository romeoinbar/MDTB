<?php namespace Lib\Repository\Episode;

use Episode, Helpers, Event;
use Lib\Services\Db\Writer;
use Lib\Repository\Episode\EpisodeRepositoryInterface;

class DbEpisode implements EpisodeRepositoryInterface
{
    /**
     * dbWriter instance.
     * 
     * @var Lib\Services\Db\Writer
     */
    private $dbWriter;

    /**
     * Episode model instance.
     * 
     * @var Episode
     */
    private $episode;


    public function __construct(Writer $dbWriter, Episode $episode)
    {
        $this->episode = $episode;
        $this->dbWriter = $dbWriter;
    }

    /**
     * Handles new episode creation/updating.
     * 
     * @param  array $input
     * @return void
     */
    public function create(array $input)
    {
        $this->dbWriter->CompileInsert('episodes', $input)
                       ->save();

        Event::fire('Titles.Modified', array($input['title_id']));
    }

    /**
     * Handles episode deletion.
     * 
     * @param  string $episode
     * @return void
     */
    public function delete($episode)
    {
        $this->episode->destroy($episode);
    }
}