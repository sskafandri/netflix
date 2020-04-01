<?php
class VideoProvider{
    public static function getUpNext($con,$currentVideo){
        $query = $con->prepare("SELECT * FROM videos
                                WHERE entityId=:entityId AND id !=:videoId
                                AND (
                                    (season =:season AND episode >:episode) OR season >:season
                                ) 
                                ORDER BY season, episode ASC LIMIT 1");
                                //selecting the video from video table where video is of same entity and videoid is where we are not watching
                                //AND (give the vidoes where we are currently on and videos are greater than of the season where we are currently on seaon) season 5 and epison 6 all geater than 6 will be shown
                                // OR we no videos in the current season give the next season
        $query->bindValue(":entityId",$currentVideo->getEntityId());
        $query->bindValue(":season",$currentVideo->getSeasonNumber());
        $query->bindValue(":episode",$currentVideo->getEpisodeNumber());
        $query->bindValue(":videoId",$currentVideo->getId());
        $query->execute();

        if($query->rowCount()==0){
            $query = $con->prepare("SELECT * FROM videos
                                    WHERE season <=1 AND episode <=1
                                    AND id !=:videoId
                                    ORDER BY views DESC LIMIT 1");
                                    


                                    //this is faltu ki line no use full line..
                                    //season is less   than 1 or 0 zero means movie episode should be 0 or 1 ..1 means 1
                                    //id != videoId this makes sure we dont select current we are watching
                                    //video with the highest views comes first

            $query->bindValue(":videoId",$currentVideo->getId());
            $query->execute();
        }
        $row = $query->fetch(PDO::FETCH_ASSOC);
        return new Video($con,$row); //object of video class created
    }

}

?>