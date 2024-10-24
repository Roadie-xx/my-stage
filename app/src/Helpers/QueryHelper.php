<?php

namespace App\Helpers;

class QueryHelper
{
    public function getCharacterInfo(int $id): string {
        return sprintf('query {
            charactersByIds(ids: [%d] ) {
                id,
                name,
                image
            }
        }', $id);
    }

    public function getEpisode(string $episode): string {
        return sprintf('query {
            episodes(filter: {name: "%s"}) {
                info {
                    count
                    pages
                    next
                    prev
                }
                results {
                    characters {
                        id,
                        name,
                        image,
                        location {
                            name
                        },
                        species,
                        status
                    }
                }
            }
        }', $episode);
    }

    public function getLocation(string $location): string {
        return sprintf('query {
            locations(filter: {name: "%s"}) {
                info {
                    count
                    pages
                    next
                    prev
                }
                results {
                    residents {
                        id,
                        name,
                        image,
                        location {
                            name
                        },
                        species,
                        status
                    }
                }
            }
        }', $location);
    }

    public function getDimension(string $dimension): string {
        return sprintf('query {
            locations(filter: {dimension: "%s"}) {
                info {
                    count
                    pages
                    next
                    prev
                }
                results {
                    residents {
                        id,
                        name,
                        image,
                        location {
                            name
                        },
                        species,
                        status
                    }
                }
            }
        }', $dimension);
    }

}