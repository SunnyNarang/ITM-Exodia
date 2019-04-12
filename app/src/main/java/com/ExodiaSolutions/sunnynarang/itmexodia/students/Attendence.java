package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.Link;
import com.amulyakhare.textdrawable.TextDrawable;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import org.apache.commons.io.FileUtils;
import org.json.JSONException;

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
import java.text.DecimalFormat;
import java.util.ArrayList;

public class Attendence extends AppCompatActivity {
    WaveHelper mWaveHelper;
    String section;
    TextView percent_tv;
    int mpercentage;
    String roll,offline_Attendance="";
    AttendanceLoader attendanceLoader;
    TextView class_att,class_total;
    public int mBorderColor;
    ListView listView;
    TextView tv;
    String class_id;
    ProgressDialog pd;
    CustomAdapter3 adapter;
    ArrayList<AttendanceData> arrayList = new ArrayList<AttendanceData>();
    static String[] color = {"9c000000","FF7043", "8D6E63", "26A69A", "7E57C2", "42A5F5", "29B6F6", "26A69A", "FF7043", "BDBDBD", "78909C"};
    private int mBorderWidth = 10;

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                Attendence.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_attendence);
        roll= getIntent().getStringExtra("roll");
        //class_id= getIntent().getStringExtra("class_id");
        section = getIntent().getStringExtra("section");
        readItems();
       // Toast.makeText(this, ""+offline_Attendance, Toast.LENGTH_SHORT).show();
        ActionBar actionBar = getSupportActionBar();
        actionBar.setBackgroundDrawable(new ColorDrawable(Color.parseColor("#ff6138")));
        actionBar.setTitle("Attendance");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);

        tv = (TextView) findViewById(R.id.days_to_go);


        listView = (ListView) findViewById(R.id.wave_lv);
        adapter = new CustomAdapter3(this,arrayList);
        listView.setAdapter(adapter);

/*
        class_att = (TextView) findViewById(R.id.class_att);
        class_total= (TextView) findViewById(R.id.class_total);
        percent_tv= (TextView) findViewById(R.id.percentage_tv);
*/
        attendanceLoader = new AttendanceLoader(Attendence.this);
        if(!offline_Attendance.equalsIgnoreCase("")){
          //  Toast.makeText(this, ""+offline_Attendance, Toast.LENGTH_SHORT).show();
            readItems();
           String[] yo = offline_Attendance.split("``%f%``");
           /* int gone = Integer.parseInt(yo[1]);
            int done = Integer.parseInt(yo[0]);
            if((gone*3-done*4)%6==0&&gone*3-done*4>0)
            tv.setText((Integer.parseInt(yo[1])*3-Integer.parseInt(yo[0])*4)/6+"");
            else if((gone*3-done*4)%6!=0&&gone*3-done*4>0)
                tv.setText(((Integer.parseInt(yo[1])*3-Integer.parseInt(yo[0])*4)/6)+1+"");
            else    tv.setText("0");
            arrayList.clear();
            if(yo.length==3)*/
            try {
                arrayList.addAll(AttendanceData.jsonToArraylist(yo[0],yo[1],roll));
            } catch (JSONException e) {
                e.printStackTrace();
            }

            //wave(offline_Attendance);
        }
        if(isNetworkAvailable()){

            attendanceLoader.execute();
            Handler handler = new Handler();
            handler.postDelayed(new Runnable()
            {
                @Override
                public void run() {
                    if ( attendanceLoader.getStatus() == AsyncTask.Status.RUNNING )
                    {attendanceLoader.cancel(true);
                       // Toast.makeText(Attendence.this, "Time OUT", Toast.LENGTH_SHORT).show();
                     if(pd.isIndeterminate())
                        pd.dismiss();
                    }
                }
            }, 20000 );
        }
        else
        {
            if(offline_Attendance.equalsIgnoreCase(""))
                Toast.makeText(Attendence.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
        }

    }

    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }


    @Override
    protected void onPause() {
        super.onPause();
        if(attendanceLoader.getStatus()==AsyncTask.Status.RUNNING)
            attendanceLoader.cancel(true);

    }

    @Override
    protected void onResume() {
        super.onResume();

       // mWaveHelper.start();
    }


    public class AttendanceLoader extends AsyncTask<Void, Void, String> {

        Context context;
        AlertDialog alertdialog;

        AttendanceLoader(Context context) {
            this.context = context;
        }


        @Override
        protected String doInBackground(Void... params) {


            String login_url = null;

            if( Link.getInstance().getHashMapLink().containsKey("attendance_view_st_panel")){
                login_url = Link.getInstance().getHashMapLink().get("attendance_view_st_panel");
            }
                try {

                    URL url = new URL(login_url);
                    HttpURLConnection httpurlconnection = (HttpURLConnection) url.openConnection();
                    httpurlconnection.setRequestProperty("Accept","text/html");
                    httpurlconnection.setRequestMethod("POST");
                    httpurlconnection.setDoOutput(true);
                    httpurlconnection.setDoInput(true);

                    OutputStream outputstream = httpurlconnection.getOutputStream();
                    BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                    String post_data = URLEncoder.encode("roll", "UTF-8") + "=" + URLEncoder.encode(roll, "UTF-8")+ "&"
                            + URLEncoder.encode("section", "UTF-8") + "=" + URLEncoder.encode(section, "UTF-8");;
                    bufferedwriter.write(post_data);
                    bufferedwriter.flush();
                    bufferedwriter.close();

                    InputStream inputstream = httpurlconnection.getInputStream();
                    BufferedReader bufferedreader = new BufferedReader(new InputStreamReader(inputstream, "iso-8859-1"));
                    String result = "";
                    String line = "";
                    while ((line = bufferedreader.readLine()) != null) {
                        result += line;
                    }
                    bufferedreader.close();
                    inputstream.close();
                    httpurlconnection.disconnect();

                    return result;

                } catch (MalformedURLException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            return "";
        }


        @Override
        protected void onPreExecute() {
          //  Toast.makeText(context, ""+class_id+" "+ roll, Toast.LENGTH_SHORT).show();
            if(offline_Attendance.equalsIgnoreCase("")){
                pd = new ProgressDialog(Attendence.this);
                pd.setTitle("Loading.");
                pd.setMessage("Please wait...\nLoading Subjects.");
                pd.setCancelable(false);
                pd.show();}

            alertdialog = new AlertDialog.Builder(context).create();
            alertdialog.setTitle("Login Status");
        }

        @Override
        protected void onPostExecute(String result) {
         // Toast.makeText(context, ""+result, Toast.LENGTH_SHORT).show();
            if(offline_Attendance.equalsIgnoreCase("")) {
                pd.dismiss();
            }
                if (!result.equalsIgnoreCase("")) {
                    writeItems(result);
                    readItems();
                    String[] yo = result.split("``%f%``");
                   /* int gone = Integer.parseInt(yo[1]);
                    int done = Integer.parseInt(yo[0]);
                    if((gone*3-done*4)%6==0&&gone*3-done*4>0)
                        tv.setText((Integer.parseInt(yo[1])*3-Integer.parseInt(yo[0])*4)/6+"");
                    else if((gone*3-done*4)%6!=0&&gone*3-done*4>0)
                        tv.setText(((Integer.parseInt(yo[1])*3-Integer.parseInt(yo[0])*4)/6)+1+"");
                    else    tv.setText("0");

                    arrayList.clear();
                    if(yo.length==3)*/
                    try {
                        arrayList.clear();
                        AttendanceData.total_gone="0";
                        AttendanceData.total_class="0";
                        arrayList.addAll(AttendanceData.jsonToArraylist(yo[0],yo[1],roll));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    //wave(yo[0],yo[1],);
                    adapter.notifyDataSetChanged();
                }

        }
        }
    private void writeItems(String s) {

        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,roll+"Attendance.txt");
        try {


            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void readItems()  {

        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,roll+"Attendance.txt");
        try {
            offline_Attendance = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_Attendance = "";
        }
    }

public void wave(String str1,String str2,View a)
{

    mWaveHelper.level=Float.parseFloat(str1)/Float.parseFloat(str2);
    // Toast.makeText(Attendence.this, ""+mWaveHelper.level, Toast.LENGTH_SHORT).show();
    if(mWaveHelper.level>=.75)
    {
        WaveView waveView;
        //waveView.setWaveColor(Color.parseColor("#40217d16"),Color.parseColor("#80217d16"));
        mBorderColor = Color.parseColor("#217d16");
        mpercentage = Color.parseColor("#084e08");
        waveView = (WaveView) a.findViewById(R.id.wave);
        waveView.setBorder(mBorderWidth, mBorderColor);

        waveView.mBehindWaveColor=Color.parseColor("#40217d16");
        waveView.mFrontWaveColor=Color.parseColor("#80217d16");
        mWaveHelper = new WaveHelper(waveView);
        mWaveHelper.start();
    }
    else if(mWaveHelper.level<=.40 || str1.equalsIgnoreCase("0")){
        WaveView waveView ;
        mBorderColor = Color.parseColor("#da3525");
        mpercentage = Color.parseColor("#b32113");
        waveView = (WaveView) a.findViewById(R.id.wave);
        waveView.setBorder(mBorderWidth, mBorderColor);
        waveView.mBehindWaveColor=Color.parseColor("#40da3525");
        waveView.mFrontWaveColor=Color.parseColor("#80da3525");
        mWaveHelper = new WaveHelper(waveView);
        mWaveHelper.start();
    }
    else {
        WaveView waveView ;
        mBorderColor = Color.parseColor("#e4892a");
        mpercentage = Color.parseColor("#b36616");
        waveView = (WaveView) a.findViewById(R.id.wave);
        waveView.setBorder(mBorderWidth, mBorderColor);

        waveView.mBehindWaveColor = Color.parseColor("#40e4892a");
        waveView.mFrontWaveColor = Color.parseColor("#80e4892a");
         //  waveView.setWaveColor(Color.parseColor("#40e4892a"),Color.parseColor("#80e4892a"));
        mWaveHelper = new WaveHelper(waveView);
        mWaveHelper.start();
    }


    percent_tv.setTextColor(mpercentage);
    DecimalFormat df = new DecimalFormat("#.#");
    String per = df.format(mWaveHelper.level*100);
    if(str1.equalsIgnoreCase("0"))
        per="0.0";
    percent_tv.setText(per+"%");

    class_att.setText(""+str1);
    class_total.setText(""+str2);
}


    class CustomAdapter3 extends ArrayAdapter<AttendanceData> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<AttendanceData> arrayList) {
            super(context, R.layout.attendance_wave_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {



            if(pos == 0){

                LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
                convertView = li.inflate(R.layout.attendance_wave_card, parent, false);

                class_att = (TextView) convertView.findViewById(R.id.class_att);
            class_total= (TextView) convertView.findViewById(R.id.class_total);
            percent_tv= (TextView) convertView.findViewById(R.id.percentage_tv);
               String[] a= offline_Attendance.split("``%f%``");
            wave(AttendanceData.total_gone,AttendanceData.total_class,convertView);
                }
            else{
                AttendanceData data = getItem(pos);
                LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
                convertView = li.inflate(R.layout.attendance_moredata_card, parent, false);

               // TextView sub_id = (TextView) convertView.findViewById(R.id.att_subject_id);
                TextView subject = (TextView) convertView.findViewById(R.id.att_subject);
                TextView attended = (TextView) convertView.findViewById(R.id.att_sub_att);
                TextView total_class = (TextView) convertView.findViewById(R.id.att_sub_from);

               // sub_id.setText(data.getSub_id());
                subject.setText(data.getSubject());
                attended.setText(data.getWent());
                total_class.setText(data.getOut_of());
              //  Toast.makeText(c, ""+data.getSubject_type(), Toast.LENGTH_SHORT).show();
                ImageView imageView = (ImageView) convertView.findViewById(R.id.att_image);
                int col=pos;
                if(pos>=10){
                    col=pos%10;
                }
                TextDrawable drawable = TextDrawable.builder()
                        .buildRound(">", Color.parseColor("#"+color[col]));
                imageView.setImageDrawable(drawable);
            }

            return convertView;

        }
    }


    }




