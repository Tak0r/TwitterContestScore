<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Models
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%contest}}".
 *
 * @property string $id
 * @property string $name
 * @property string $trigger
 * @property string $year
 * @property integer $active
 * @property string $last_parsed_tweet_id
 * @property string $last_parse
 * @property string $parse_from
 * @property string $parse_to
 * @property string $crawler_profile_id
 * @property string $custom_regex_entry
 * @property string $custom_regex_rating
 * @property string $next_result_query
 * @property string $create_time
 * @property string $update_time
 *
 * @property Tweet $lastParsedTweet
 * @property CrawlerProfile $crawlerProfile
 * @property CrawlerData[] $crawlerData
s * @property Entry[] $entries 
 * @property Tweet[] $tweets
 */
class Contest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contest}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
               'class' => \yii\behaviors\TimestampBehavior::className(),
               'createdAtAttribute' => 'create_time',
               'updatedAtAttribute' => 'update_time',
               'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'trigger', 'year', 'parse_from', 'parse_to'], 'required'],
            [['last_parsed_tweet_id', 'crawler_profile_id'], 'integer'],
            [['parse_from', 'parse_to'], 'date', 'format' => 'php:Y-m-d'],
            [['last_parse'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['create_time', 'update_time'], 'safe'],
            [['custom_regex_entry', 'custom_regex_rating'], 'string'],
            [['name', 'trigger', 'next_result_query'], 'string', 'max' => 255],
            [['active'], 'boolean'],
            [['year'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'trigger' => Yii::t('app', 'Trigger'),
            'year' => Yii::t('app', 'Year'),
            'active' => Yii::t('app', 'Active'),
            'last_parsed_tweet_id' => Yii::t('app', 'Last Parsed Tweet'),
            'last_parse' => Yii::t('app', 'Last Parse'),
            'parse_from' => Yii::t('app', 'Parse From'),
            'parse_to' => Yii::t('app', 'Parse To'),
            'crawler_profile_id' => Yii::t('app', 'Crawler Profile'),
            'custom_regex_entry' => Yii::t('app', 'Custom Regex Entry'),
            'custom_regex_rating' => Yii::t('app', 'Custom Regex Rating'),
            'next_result_query' => Yii::t('app', 'Next Query Result'),         
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEntries() 
    { 
        return $this->hasMany(Entry::className(), ['contest_id' => 'id']); 
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastParsedTweet()
    {
        return $this->hasOne(Tweet::className(), ['id' => 'last_parsed_tweet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrawlerProfile()
    {
        return $this->hasOne(CrawlerProfile::className(), ['id' => 'crawler_profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrawlerDatas()
    {
        return $this->hasMany(CrawlerData::className(), ['contest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTweets()
    {
        return $this->hasMany(Tweet::className(), ['contest_id' => 'id']);
    }
}
