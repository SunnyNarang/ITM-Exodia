package com.ExodiaSolutions.sunnynarang.itmexodia.students;

/**
 * Created by Sunny Narang on 16-07-2016.
 */

public class routine_class {

    String start_time,end_time;
    String sub_code,sub_name;
    routine_class(String start_time,String end_time,String sub_code,String sub_name){
        this.start_time=start_time;
        this.end_time=end_time;
        this.sub_code=sub_code;
        this.sub_name=sub_name;
    }

    public String getSub_code() {
        return sub_code;
    }

    public String getSub_name() {
        return sub_name;
    }

    public String getStart_time() {
        return start_time;
    }

    public String getEnd_time() {
        return end_time;
    }
}
