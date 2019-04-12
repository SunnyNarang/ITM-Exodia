package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v4.view.ViewPager;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import org.apache.commons.io.FileUtils;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.Calendar;

import github.chenupt.springindicator.SpringIndicator;

public class Routine_Page extends AppCompatActivity  {
    ViewPager viewPager;
    static String class_id,roll,batch;
    int day;
    TimeTableLoader timeTableLoader = new TimeTableLoader(Routine_Page.this);

    @Override
    protected void onDestroy() {
        if(timeTableLoader.getStatus()==AsyncTask.Status.RUNNING)
            timeTableLoader.cancel(true);
        super.onDestroy();
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                Routine_Page.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_routine__page);

        // Get the ViewPager and set it's PagerAdapter so that it can display items

        viewPager = (ViewPager) findViewById(R.id.viewpager);


        Calendar calendar = Calendar.getInstance();

        day = calendar.get(Calendar.DAY_OF_WEEK);

        switch (day) {
            case Calendar.SUNDAY:{day=0;break;}
                // Current day is Sunday

            case Calendar.MONDAY:{day=0;break;}
                // Current day is Monday

            case Calendar.TUESDAY:{day=1;break;}

            case Calendar.WEDNESDAY:{day=2;break;}
            // Current day is Sunday

            case Calendar.THURSDAY:{day=3;break;}
            // Current day is Monday

            case Calendar.FRIDAY:{day=4;break;}

            case Calendar.SATURDAY:{day=5;break;}
                // etc.
        }

        class_id = getIntent().getStringExtra("class_id");
        batch=getIntent().getStringExtra("batch");
       // Toast.makeText(this, ""+batch+" "+class_id, Toast.LENGTH_SHORT).show();
        viewPager.setAdapter(new RoutineFragmentPagerAdapter(getSupportFragmentManager()));
        viewPager.setCurrentItem(day);
        SpringIndicator springIndicator= (SpringIndicator) findViewById(R.id.indicator);
        springIndicator.setViewPager(viewPager);

        if(isNetworkAvailable()){
         timeTableLoader=new TimeTableLoader(this);
        timeTableLoader.execute();

            Handler handler = new Handler();
            handler.postDelayed(new Runnable()
            {
                @Override
                public void run() {
                    if ( timeTableLoader.getStatus() == AsyncTask.Status.RUNNING )
                    {timeTableLoader.cancel(true);
                        Toast.makeText(Routine_Page.this, "Time OUT", Toast.LENGTH_SHORT).show();
                    }
                }
            }, 20000 );
        }


        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Class Routine");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);
        //git repository link -https://github.com/ToxicBakery/ViewPagerTransforms/tree/master/library/src/main/java/com/ToxicBakery/viewpager/transforms
        //add dependencies-  compile 'com.ToxicBakery.viewpager.transforms:view-pager-transforms:1.2.32@aar'
        //viewPager.setPageTransformer(true, new RotateDownTransformer());




    }
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }


    public class TimeTableLoader extends AsyncTask<String,Void,String> {

        Context context;
        TimeTableLoader(Context context)
        {
            this.context=context;
        }

        @Override
        protected String doInBackground(String... params) {

            String login_url= "https://exodia-incredible100rav.c9users.io/android/php/gettimetable.php";


            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);
                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("class_id", "UTF-8") + "=" + URLEncoder.encode(class_id, "UTF-8") + "&"
                        + URLEncoder.encode("batch", "UTF-8") + "=" + URLEncoder.encode(batch, "UTF-8");;
                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return "0";

        }

        @Override
        protected void onPostExecute(String result ){
         //  Toast.makeText(context, ""+result, Toast.LENGTH_SHORT).show();
            if(!result.equalsIgnoreCase("0")) {
                //Toast.makeText(Routine_Page.this, "FUCK U", Toast.LENGTH_SHORT).show();
                File filesDir = getFilesDir();
                File todoFile = new File(filesDir, class_id+batch+"class_routine.txt");
                try {
                    FileUtils.writeStringToFile(todoFile, result);   // TODO: add depenencies for fill utils
                } catch (IOException e) {
                    e.printStackTrace();
                }

                viewPager.setAdapter(new RoutineFragmentPagerAdapter(getSupportFragmentManager()));
                viewPager.setCurrentItem(day);
            }

        }

    }

}
