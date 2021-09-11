object FormMain: TFormMain
  Left = 0
  Top = 0
  Caption = 'Lizardry'
  ClientHeight = 487
  ClientWidth = 984
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  WindowState = wsMaximized
  OnCreate = FormCreate
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  inline FrameLogin: TFrameLogin
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 0
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Image1: TImage
      Width = 734
      Height = 487
      ExplicitWidth = 734
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 487
      ExplicitHeight = 487
    end
  end
  inline FrameRegistration: TFrameRegistration
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 1
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Image1: TImage
      Width = 734
      Height = 487
      ExplicitWidth = 734
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 487
      ExplicitHeight = 487
    end
  end
  inline FrameTown: TFrameTown
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Panel7: TPanel
      Left = 703
      Height = 487
      ExplicitLeft = 703
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 487
      ExplicitHeight = 487
    end
    inherited Panel9: TPanel
      Width = 422
      Height = 487
      ExplicitWidth = 422
      ExplicitHeight = 487
      inherited Panel10: TPanel
        Width = 422
        ExplicitWidth = 422
      end
      inherited StaticText1: TStaticText
        Width = 422
        ExplicitLeft = -6
        ExplicitTop = 31
        ExplicitWidth = 422
      end
      inherited FramePanel: TPanel
        Top = 237
        Width = 422
        ExplicitTop = 237
        ExplicitWidth = 422
        inherited FrameBank1: TFrameBank
          Width = 420
          ExplicitTop = 1
          ExplicitWidth = 420
          ExplicitHeight = 248
        end
        inherited FrameDefault1: TFrameDefault
          Width = 420
          ExplicitLeft = 1
          ExplicitTop = 1
          ExplicitWidth = 420
        end
      end
    end
  end
end
