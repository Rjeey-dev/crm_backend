<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

class Ability
{
    public const ABILITY_SEE_ALL_ROUTES = 'ABILITY_SEE_ALL_ROUTES';
    public const ABILITY_DELETE_ROUTE = 'ABILITY_DELETE_ROUTE';
    public const ABILITY_UPDATE_ROUTE = 'ABILITY_UPDATE_ROUTE';
    public const ABILITY_DELETE_ROUTE_PACKAGE = 'ABILITY_DELETE_ROUTE_PACKAGE';
    public const ABILITY_MODERATE_ROUTE_PACKAGE = 'ABILITY_MODERATE_ROUTE_PACKAGE';
    public const ABILITY_ADD_ROUTE_PACKAGE = 'ABILITY_ADD_ROUTE_PACKAGE';
    public const ABILITY_REJECT_ROUTE_PACKAGE_MODERATION = 'ABILITY_REJECT_ROUTE_PACKAGE_MODERATION';
    public const ABILITY_VIEW_ROUTE = 'ABILITY_VIEW_ROUTE';
    public const ABILITY_SEE_ALL_USERS = 'ABILITY_SEE_ALL_USERS';
    public const ABILITY_DELETE_USER = 'ABILITY_DELETE_USER';
    public const ABILITY_BAN_USER = 'ABILITY_BAN_USER';
    public const ABILITY_UNBAN_USER = 'ABILITY_UNBAN_USER';
    public const ABILITY_UPDATE_USER = 'ABILITY_UPDATE_USER';
    public const ABILITY_GET_FIND_ME_A_TOUR_REQUESTS = 'ABILITY_GET_FIND_ME_A_TOUR_REQUESTS';
    public const ABILITY_GET_NEWS_SUBSCRIPTIONS = 'ABILITY_GET_NEWS_SUBSCRIPTIONS';
}